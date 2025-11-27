<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use common\models\User;
use common\models\Perfil;
use common\models\Condominio; // <--- NOVO
use common\models\Fracao;     // <--- NOVO
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function () {
                    Yii::$app->user->logout();
                    return $this->redirect(['site/login']);
                },
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['sysadmin', 'adminCondominio'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Dashboard Principal.
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;
        $isSysAdmin = Yii::$app->user->can('sysadmin');

        // --- ESTATÍSTICAS (Contagens) ---
        $totalUsers = User::find()->count();
        $admins = Perfil::find()->where(['perfil' => 'ADMIN_CONDOMINIO'])->count();
        $proprietarios = Perfil::find()->where(['perfil' => 'PROPRIETARIO'])->count();
        $sysadmins = Perfil::find()->where(['perfil' => 'SYS_ADMIN'])->count();

        // --- LISTA DE CONDOMÍNIOS DO UTILIZADOR ---
        // Aqui vamos buscar os DADOS reais, não só a contagem
        $queryMeusCondominios = Condominio::find();

        if (!$isSysAdmin) {
            $queryMeusCondominios->where(['admin_id' => $userId]);
        }

        // Pega nos condomínios (para listar na tabela)
        $meusCondominios = $queryMeusCondominios->all();
        // Conta-os (para o widget colorido)
        $totalCondominios = count($meusCondominios);


        // --- CONTAGEM DE FRAÇÕES ---
        $queryFracoes = Fracao::find();
        if (!$isSysAdmin) {
            $queryFracoes->joinWith('condominio')
                ->where(['condominios.admin_id' => $userId]);
        }
        $totalFracoes = $queryFracoes->count();


        return $this->render('index', compact(
            'totalUsers', 'admins', 'proprietarios', 'sysadmins',
            'totalCondominios', 'totalFracoes', 'isSysAdmin',
            'meusCondominios' // <--- Envia a lista para a view
        ));
    }
    /**
     * Login action.
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
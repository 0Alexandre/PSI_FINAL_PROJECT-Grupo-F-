<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use common\models\User;
use common\models\Perfil;
use common\models\Condominio;
use common\models\Fracao;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use common\models\ChangePasswordForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    // Define permissões de acesso: Apenas 'sysadmin' e 'adminCondominio' podem entrar no Dashboard
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                // Se o acesso for negado, faz logout e manda para a página de login
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
                        'actions' => ['index', 'logout', 'change-password'],
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

    // Dashboard Principal: Calcula estatísticas e filtra os dados para que o Admin de Condomínio veja apenas o seu portfólio
    /**
     * Dashboard Principal.
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;
        $isSysAdmin = Yii::$app->user->can('sysadmin');

        // Estatísticas globais (contadores simples)
        $totalUsers = User::find()->count();
        $admins = Perfil::find()->where(['perfil' => 'ADMIN_CONDOMINIO'])->count();
        $proprietarios = Perfil::find()->where(['perfil' => 'PROPRIETARIO'])->count();
        $sysadmins = Perfil::find()->where(['perfil' => 'SYS_ADMIN'])->count();

        // Lógica de Condomínios: Se não for Sysadmin, filtra pelos condomínios do user
        $queryMeusCondominios = Condominio::find();
        if (!$isSysAdmin) {
            $queryMeusCondominios->where(['admin_id' => $userId]);
        }
        $meusCondominios = $queryMeusCondominios->all();
        $totalCondominios = count($meusCondominios);

        // Lógica de Frações: Se não for Sysadmin, faz join para contar apenas frações dos condomínios dele
        $queryFracoes = Fracao::find();
        if (!$isSysAdmin) {
            $queryFracoes->joinWith('condominio')
                ->where(['condominios.admin_id' => $userId]);
        }
        $totalFracoes = $queryFracoes->count();


        return $this->render('index', compact(
            'totalUsers', 'admins', 'proprietarios', 'sysadmins',
            'totalCondominios', 'totalFracoes', 'isSysAdmin',
            'meusCondominios'
        ));
    }

    // Gere o processo de autenticação (Login) e define o layout da página
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

    // Termina a sessão do utilizador (Logout) e redireciona para a home
    /**
     * Logout action.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    // Permite ao utilizador alterar a sua própria palavra-passe por questões de segurança
    public function actionChangePassword()
    {
        // Se não estiver logado, manda embora
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash('success', 'Password alterada com sucesso!');
            return $this->goHome();
        }

        return $this->render('change-password', [
            'model' => $model,
        ]);
    }
}
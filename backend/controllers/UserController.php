<?php

namespace backend\controllers;

use common\models\User;
use common\models\Perfil;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    // Define permissões: Apenas o 'sysadmin' tem acesso total à gestão de utilizadores
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['sysadmin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    // Lista todos os utilizadores registados e permite pesquisar
    /**
     * Lists all User models.
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // Mostra os detalhes completos de um utilizador e do seu perfil
    /**
     * Displays a single User model.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // Cria um novo utilizador e o respetivo perfil. Gera uma password provisória se não for definida e atribui a permissão (Role)
    /**
     * Creates a new User model AND a new Perfil model.
     */
    public function actionCreate()
    {
        $model = new User();
        $perfil = new Perfil();

        if ($model->load(Yii::$app->request->post()) && $perfil->load(Yii::$app->request->post())) {

            // Lógica de Password: Se vier vazia, gera uma aleatória de 8 caracteres
            if (empty($model->password)) {
                $randomPass = Yii::$app->security->generateRandomString(8);
                $model->password = $randomPass;
                $msgPassword = 'A Password Temporária é: <strong style="font-size:1.2em">' . $randomPass . '</strong> 
                <br> ⚠️ (Copie agora e envie esta password ao utilizador por Email ou SMS!)';
            } else {
                $msgPassword = 'A Password foi definida manualmente.';
            }

            // Configurações do User (Hash da password e AuthKey)
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->status = User::STATUS_ACTIVE;

            if ($model->save()) {

                // Associa o perfil ao ID do utilizador acabado de criar
                $perfil->user_id = $model->id;
                $perfil->save();

                // Atribui a Role (Permissão) no RBAC
                if (!empty($model->role)) {
                    $auth = Yii::$app->authManager;
                    $role = $auth->getRole($model->role);
                    if ($role) {
                        $auth->assign($role, $model->id);
                    }
                }

                Yii::$app->session->setFlash('success', 'Utilizador e Perfil criados! <br>' . $msgPassword);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'perfil' => $perfil,
        ]);
    }

    // Atualiza os dados do utilizador e do perfil. Também atualiza as permissões (Role) se forem alteradas
    /**
     * Updates an existing User model AND Perfil model.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Carrega o perfil existente ou cria um novo em memória se não existir
        $perfil = $model->perfil;
        if (!$perfil) {
            $perfil = new Perfil();
            $perfil->user_id = $model->id;
        }

        if ($model->load(Yii::$app->request->post()) && $perfil->load(Yii::$app->request->post())) {

            // Tenta gravar ambos os modelos
            $isValid = $model->save();
            $isValid = $perfil->save() && $isValid;

            if ($isValid) {
                // Atualiza a Role no RBAC (Remove as antigas e mete a nova)
                if (!empty($model->role)) {
                    $auth = Yii::$app->authManager;
                    $auth->revokeAll($model->id);
                    $role = $auth->getRole($model->role);
                    if ($role) {
                        $auth->assign($role, $model->id);
                    }
                }

                Yii::$app->session->setFlash('success', 'Utilizador atualizado com sucesso.');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'perfil' => $perfil,
        ]);
    }

    // Desativa um utilizador (Soft Delete) em vez de apagar da base de dados, por segurança
    /**
     * Deletes (Soft Delete) an existing User model.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = User::STATUS_DELETED;

        if($model->save(false)) {
            Yii::$app->session->setFlash('success', 'O utilizador foi desativado com sucesso!');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao desativar utilizador.');
        }

        return $this->redirect(['index']);
    }

    // Procura o utilizador pelo ID e lança erro 404 se não existir
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
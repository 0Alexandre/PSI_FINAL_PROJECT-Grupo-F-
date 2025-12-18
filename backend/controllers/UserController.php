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

    /**
     * Displays a single User model.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model AND a new Perfil model.
     */
    public function actionCreate()
    {
        $model = new User();
        $perfil = new Perfil();

        // Carregar dados do POST para AMBOS os modelos
        if ($model->load(Yii::$app->request->post()) && $perfil->load(Yii::$app->request->post())) {

            $model->setPassword('12345678');
            $model->generateAuthKey();
            $model->status = User::STATUS_ACTIVE;

            if ($model->save()) {

                $perfil->user_id = $model->id;

                $perfil->save();

                if (!empty($model->role)) {
                    $auth = Yii::$app->authManager;
                    $role = $auth->getRole($model->role);
                    if ($role) {
                        $auth->assign($role, $model->id);
                    }
                }

                Yii::$app->session->setFlash('success', 'Utilizador e Perfil criados! Password: <strong>12345678</strong>');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'perfil' => $perfil,
        ]);
    }

    /**
     * Updates an existing User model AND Perfil model.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $perfil = $model->perfil;
        if (!$perfil) {
            $perfil = new Perfil();
            $perfil->user_id = $model->id;
        }

        if ($model->load(Yii::$app->request->post()) && $perfil->load(Yii::$app->request->post())) {

            // Gravar ambos
            $isValid = $model->save();
            $isValid = $perfil->save() && $isValid;
            if ($isValid) {
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

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
<?php

namespace backend\controllers;

use common\models\Mensagens;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use yii\filters\AccessControl;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * MensagemController implements the CRUD actions for Mensagens model.
 */
class MensagemController extends Controller
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
                        'roles' => ['adminCondominio', 'sysadmin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Mensagens models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Mensagens::find();

        if (!Yii::$app->user->can('sysadmin')) {
            $query->where([
                'OR',
                ['destinatario_id' => Yii::$app->user->id],
                ['remetente_id' => Yii::$app->user->id]
            ]);
        }

        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $query,]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mensagens model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Mensagens model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Mensagens();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->remetente_id = Yii::$app->user->id;
            $model->data_envio = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Mensagem enviada!');
                return $this->redirect(['index']);
            }
        }

        if (Yii::$app->user->can('sysadmin')) {
            $users = User::find()->where(['status' => 10])->all();
        } else {
            $users = User::find()
                ->joinWith('fracao.condominio')
                ->where(['condominios.admin_id' => Yii::$app->user->id])
                ->all();
        }

        $listaDestinatarios = ArrayHelper::map($users, 'id', function($user){
            return $user->username . ' (' . $user->id . ')';
        });

        return $this->render('create', [
            'model' => $model,
            'listaDestinatarios' => $listaDestinatarios,
        ]);
    }

    /**
     * Updates an existing Mensagens model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if (Yii::$app->user->can('sysadmin')) {
            $users = User::find()->where(['status' => 10])->all();
        } else {
            $users = User::find()
                ->joinWith('fracao.condominio')
                ->where(['condominios.admin_id' => Yii::$app->user->id])
                ->all();
        }

        $listaDestinatarios = ArrayHelper::map($users, 'id', function($user){
            return $user->username . ' (' . $user->id . ')';
        });

        return $this->render('update', [
            'model' => $model,
            'listaDestinatarios' => $listaDestinatarios,
        ]);
    }

    /**
     * Deletes an existing Mensagens model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Mensagens model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Mensagens the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mensagens::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

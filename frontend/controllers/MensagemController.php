<?php

namespace frontend\controllers;

use common\models\Mensagens;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Condominio;

class MensagemController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Mensagens();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->remetente_id = Yii::$app->user->id;
                $model->data_envio = date('Y-m-d H:i:s');

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Mensagem enviada com sucesso!');
                    return $this->redirect(['index']);
                }
            }
        }

        $user = Yii::$app->user->identity;

        $meuCondominio = $user->getCondominio();

        $destinatarios = [];

        if ($meuCondominio) {
            $destinatarios = User::find()
                ->where(['id' => $meuCondominio->admin_id])
                ->all();
        }

        return $this->render('create', [
            'model' => $model,
            'destinatarios' => $destinatarios,
        ]);
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        $recebidasProvider = new ActiveDataProvider([
            'query' => Mensagens::find()
                ->where(['destinatario_id' => $userId])
                ->orderBy(['data_envio' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $enviadasProvider = new ActiveDataProvider([
            'query' => Mensagens::find()
                ->where(['remetente_id' => $userId])
                ->orderBy(['data_envio' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'recebidasProvider' => $recebidasProvider,
            'enviadasProvider' => $enviadasProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $userId = Yii::$app->user->id;

        // Segurança: Só vejo se for remetente ou destinatário
        if ($model->remetente_id != $userId && $model->destinatario_id != $userId) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para ver esta mensagem.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Mensagens::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('A mensagem não existe.');
    }
}
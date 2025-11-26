<?php

namespace frontend\controllers;

use common\models\Mensagens;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class MensagemController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['proprietario'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        // 1. Criar uma "folha em branco" (Objeto vazio)
        $model = new Mensagens();

        // 2. Se o utilizador clicou em "Enviar" (POST)
        if ($this->request->isPost) {

            // Carrega os dados do formulário (Assunto, Corpo, Destinatário)
            if ($model->load($this->request->post())) {

                // 3. Preenchimento Automático (O utilizador não vê isto)
                // Quem envia sou eu (o utilizador logado)
                $model->remetente_id = Yii::$app->user->id;
                // A data é agora
                $model->data_envio = date('Y-m-d H:i:s');

                // 4. Tentar guardar na Base de Dados
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Mensagem enviada com sucesso!');
                    return $this->redirect(['index']);
                }
            }
        }

        // 5. Preparar a lista para o Dropdown (Para quem posso enviar?)
        // Exemplo: Todos os utilizadores ativos, exceto eu próprio
        $destinatarios = User::find()
            ->where(['status' => 10])
            ->andWhere(['<>', 'id', Yii::$app->user->id])
            ->all();

        // 6. Renderizar a View enviando as variáveis necessárias
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
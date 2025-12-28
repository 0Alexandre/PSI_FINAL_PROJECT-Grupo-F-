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

/**
 * MensagemController handles internal messaging for frontend users.
 */
class MensagemController extends \yii\web\Controller
{
    // Define as regras de acesso: Apenas utilizadores autenticados (@) podem enviar/ler mensagens
    /**
     * @inheritDoc
     */
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

    // Cria uma nova mensagem. O destinatário é automaticamente restringido ao Administrador do Condomínio do utilizador
    /**
     * Creates a new message.
     * For frontend users, the recipient list is limited to their Condominium Administrator.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Mensagens();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Define automaticamente o remetente (quem está logado) e a data atual
                $model->remetente_id = Yii::$app->user->id;
                $model->data_envio = date('Y-m-d H:i:s');

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Mensagem enviada com sucesso!');
                    return $this->redirect(['index']);
                }
            }
        }

        // Lógica para encontrar o destinatário correto (O Admin do prédio)
        $user = Yii::$app->user->identity;
        $meuCondominio = $user->getCondominio();
        $destinatarios = [];

        // Se o morador tiver condomínio, o único destinatário possível é o Admin desse condomínio
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

    // Lista as mensagens, separando-as em duas listas: "Recebidas" (Inbox) e "Enviadas" (Sent)
    /**
     * Lists all messages (Inbox and Sent) for the current user.
     *
     * @return string
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        // Provider para mensagens onde eu sou o destinatário
        $recebidasProvider = new ActiveDataProvider([
            'query' => Mensagens::find()
                ->where(['destinatario_id' => $userId])
                ->orderBy(['data_envio' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // Provider para mensagens onde eu sou o remetente
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

    // Mostra o conteúdo de uma mensagem. Inclui verificação de segurança para impedir leitura de mensagens alheias.
    /**
     * Displays a single Mensagens model.
     * Contains security check to ensure only the sender or recipient can view it.
     * @param int $id ID
     * @return string
     * @throws \yii\web\ForbiddenHttpException if the user is not related to the message
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $userId = Yii::$app->user->id;

        // Segurança: Se não sou o remetente NEM o destinatário, não posso ver isto
        if ($model->remetente_id != $userId && $model->destinatario_id != $userId) {
            throw new \yii\web\ForbiddenHttpException('Não tem permissão para ver esta mensagem.');
        }

        // Prepara o nome do remetente para exibir na vista
        if ($model->remetente) {
            $remetenteNome = $model->remetente->username;
        } else {
            $remetenteNome = 'Utilizador #' . $model->remetente_id;
        }

        return $this->render('view', [
            'model' => $model,
            'remetenteNome' => $remetenteNome,
        ]);
    }

    // Procura a mensagem pelo ID
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

        throw new NotFoundHttpException('A mensagem não existe.');
    }
}
<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use Yii;
use common\models\Reserva;
use common\models\EspacoComum;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

/**
 * ReservaController handles the creation and viewing of reservations for the frontend.
 */
class ReservaController extends \yii\web\Controller
{
    // Define as regras de acesso: Apenas utilizadores autenticados (@) podem aceder
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
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    // Lista as reservas do condomínio.
    // Mostra todas as reservas do prédio para que os vizinhos saibam o que está ocupado.
    /**
     * Lists all Reserva models relevant to the user's condominium.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Reserva::find();

        // Obtém a fração/condomínio do utilizador
        $fracao = Yii::$app->user->identity->fracao;

        if ($fracao) {
            // Filtra reservas onde o espaço comum pertence ao condomínio desta fração
            $query->joinWith('espaco')
                ->andWhere(['espacos_comuns.condominio_id' => $fracao->condominio_id]);
        } else {
            // Se o utilizador não tem fração, não mostra nada (segurança)
            $query->where('0=1');
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // Mostra os detalhes de uma reserva específica
    /**
     * Displays a single Reserva model.
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

    // Cria uma nova reserva.
    // Associa automaticamente o ID do utilizador logado e define o estado como 'Pendente'.
    /**
     * Creates a new Reserva model.
     * Automatically sets the user ID and default status.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Reserva();
        $user = Yii::$app->user->identity;
        $meuCondominio = $user->getCondominio();

        // Se o utilizador não tiver condomínio associado, manda para a home
        if (!$meuCondominio) {
            Yii::$app->session->setFlash('error', 'Precisa de estar associado a um condomínio para reservar.');
            return $this->redirect(['site/index']);
        }

        // Procura apenas espaços comuns do condomínio deste utilizador
        $espacos = EspacoComum::find()
            ->where(['condominio_id' => $meuCondominio->id])
            ->all();

        $listaEspacos = ArrayHelper::map($espacos, 'id', 'nome');

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->utilizador_id = $user->id;
                $model->estado = 'Pendente'; // Estado inicial

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Reserva criada com sucesso! Aguarde aprovação.');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'listaEspacos' => $listaEspacos,
        ]);
    }

    // Apaga (Cancela) uma reserva.
    // Inclui verificação extra: O utilizador só pode apagar as SUAS próprias reservas.
    /**
     * Deletes an existing Reserva model.
     * Includes security check to ensure users can only delete their own reservations.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException if the user is not the owner
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Segurança: Verifica se a reserva pertence a quem está logado
        if ($model->utilizador_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('Não tem permissão para cancelar esta reserva.');
        }

        $model->delete();
        Yii::$app->session->setFlash('success', 'Reserva cancelada.');

        return $this->redirect(['index']);
    }

    // Procura o modelo pelo ID
    /**
     * Finds the Reserva model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Reserva the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reserva::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('A reserva não existe.');
    }
}
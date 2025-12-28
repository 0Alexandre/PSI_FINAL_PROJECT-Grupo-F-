<?php

namespace backend\controllers;

use common\models\EspacoComum;
use common\models\Reserva;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * ReservaController implements the CRUD actions for Reserva model.
 */
class ReservaController extends Controller
{
    // Define permissões: Apenas utilizadores com permissão 'adminCondominio' (ou superior) podem gerir reservas
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
                        'roles' => ['adminCondominio'],
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

    // Lista as reservas. Se não for 'sysadmin', filtra para mostrar apenas as reservas dos condomínios geridos pelo utilizador
    /**
     * Lists all Reserva models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Reserva::find();

        if (!Yii::$app->user->can('sysadmin')) {
            // Faz o join com Espaco -> Condominio para filtrar pelo admin_id
            $query->joinWith('espaco.condominio')
                ->where(['condominios.admin_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider(['query' => $query]);

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

    // Cria uma nova reserva. O dropdown de Espaços Comuns é filtrado para mostrar apenas os dos condomínios do Admin
    /**
     * Creates a new Reserva model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Reserva();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        // Busca os espaços comuns disponíveis para reserva
        $queryEspacos = EspacoComum::find();

        // Se não for Sysadmin, filtra apenas os espaços dos condomínios dele
        if (!Yii::$app->user->can('sysadmin')) {
            $queryEspacos->joinWith('condominio')
                ->where(['condominios.admin_id' => Yii::$app->user->id]);
        }

        // Cria a lista para o dropdown (ex: "Salão de Festas - Prédio A")
        $listaEspacos = ArrayHelper::map($queryEspacos->all(), 'id', function($espaco) {
            return $espaco->nome . ' (' . $espaco->condominio->nome . ')';
        });

        return $this->render('create', [
            'model' => $model,
            'listaEspacos' => $listaEspacos,
        ]);
    }

    // Edita uma reserva. Mantém a mesma lógica de filtro de espaços do Create
    /**
     * Updates an existing Reserva model.
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

        // Lógica de filtro para o dropdown
        $queryEspacos = EspacoComum::find();
        if (!Yii::$app->user->can('sysadmin')) {
            $queryEspacos->joinWith('condominio')
                ->where(['condominios.admin_id' => Yii::$app->user->id]);
        }

        $listaEspacos = ArrayHelper::map($queryEspacos->all(), 'id', function($espaco) {
            return $espaco->nome . ' (' . $espaco->condominio->nome . ')';
        });

        return $this->render('update', [
            'model' => $model,
            'listaEspacos' => $listaEspacos,
        ]);
    }

    // Apaga uma reserva da base de dados
    /**
     * Deletes an existing Reserva model.
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

    // Procura a reserva pelo ID e lança erro 404 se não existir
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

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
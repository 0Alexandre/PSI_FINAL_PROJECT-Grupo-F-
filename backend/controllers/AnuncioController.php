<?php

namespace backend\controllers;

use common\models\Anuncio;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Condominio;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use Yii;

/**
 * AnuncioController implements the CRUD actions for Anuncio model.
 */
class AnuncioController extends Controller
{
    // Define as regras de acesso (quem pode ver a página) e os métodos HTTP permitidos
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

    // Lista todos os anúncios, filtrando apenas os condomínios do utilizador se este não for Sysadmin
    /**
     * Lists all Anuncio models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Anuncio::find();

        if (!Yii::$app->user->can('sysadmin')) {
            $query->joinWith('condominio')
                ->where(['condominios.admin_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // Exibe os detalhes de um anúncio específico
    /**
     * Displays a single Anuncio model.
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

    // Cria um novo anúncio, preenchendo a data automaticamente e carregando a lista de condomínios permitidos
    /**
     * Creates a new Anuncio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Anuncio();
        $query = Condominio::find();

        if (!Yii::$app->user->can('sysadmin')) {
            $query->where(['admin_id' => Yii::$app->user->id]);
        }

        $listaCondominios = ArrayHelper::map($query->all(), 'id', 'nome');

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->data = date('Y-m-d H:i:s');

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'listaCondominios' => $listaCondominios,
        ]);
    }

    // Atualiza um anúncio existente, mantendo a restrição da lista de condomínios
    /**
     * Updates an existing Anuncio model.
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

        $query = Condominio::find();
        if (!Yii::$app->user->can('sysadmin')) {
            $query->where(['admin_id' => Yii::$app->user->id]);
        }
        $listaCondominios = ArrayHelper::map($query->all(), 'id', 'nome');

        return $this->render('update', [
            'model' => $model,
            'listaCondominios' => $listaCondominios,
        ]);
    }

    // Apaga um anúncio da base de dados
    /**
     * Deletes an existing Anuncio model.
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

    // Procura o modelo pelo ID, garantindo que o utilizador tem permissão para o ver
    /**
     * Finds the Anuncio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Anuncio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        // Usa 'anuncio.id' para evitar ambiguidade no SQL
        $query = Anuncio::find()->where(['anuncio.id' => $id]);

        if (!Yii::$app->user->can('sysadmin')) {
            $query->joinWith('condominio')
                ->andWhere(['condominios.admin_id' => Yii::$app->user->id]);
        }

        if (($model = $query->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Página não encontrada ou sem permissão.');
    }
}
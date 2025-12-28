<?php

namespace backend\controllers;

use common\models\Fracao;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Condominio;
use yii\helpers\ArrayHelper;
use common\models\User;
use yii\filters\AccessControl;
use Yii;

/**
 * FracaoController implements the CRUD actions for Fracao model.
 */
class FracaoController extends Controller
{
    // Define que apenas utilizadores com a permissão 'adminCondominio' podem aceder a estas ações
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

    // Lista as frações. Se não for 'sysadmin', mostra apenas as dos condomínios geridos pelo utilizador
    /**
     * Lists all Fracao models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Fracao::find();

        if (!Yii::$app->user->can('sysadmin')) {
            $query->joinWith('condominio')
                ->where(['condominios.admin_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // Mostra os detalhes de uma fração específica
    /**
     * Displays a single Fracao model.
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

    // Cria uma nova fração. Filtra os condomínios no dropdown para segurança (só mostra os do admin)
    /**
     * Creates a new Fracao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Fracao();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        // Lógica de Filtro dos Condomínios
        $queryCondominios = Condominio::find();
        if (!Yii::$app->user->can('sysadmin')) {
            $queryCondominios->where(['admin_id' => Yii::$app->user->id]);
        }
        $listaCondominios = ArrayHelper::map($queryCondominios->all(), 'id', 'nome');

        // Lista de Proprietários (Filtra users com perfil PROPRIETARIO)
        $proprietarios = User::find()
            ->joinWith('perfil')
            ->where(['perfil.perfil' => 'PROPRIETARIO'])
            ->all();

        $listaProprietarios = ArrayHelper::map($proprietarios, 'id', 'username');

        return $this->render('create', [
            'model' => $model,
            'listaCondominios' => $listaCondominios,
            'listaProprietarios' => $listaProprietarios,
        ]);
    }

    // Edita uma fração. Mantém o filtro de condomínios para impedir trocas para prédios alheios
    /**
     * Updates an existing Fracao model.
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

        // Lógica de Filtro dos Condomínios
        $queryCondominios = Condominio::find();
        if (!Yii::$app->user->can('sysadmin')) {
            $queryCondominios->where(['admin_id' => Yii::$app->user->id]);
        }
        $listaCondominios = ArrayHelper::map($queryCondominios->all(), 'id', 'nome');

        // Lista de Proprietários
        $proprietarios = User::find()
            ->joinWith('perfil')
            ->where(['perfil.perfil' => 'PROPRIETARIO'])
            ->all();

        $listaProprietarios = ArrayHelper::map($proprietarios, 'id', 'username');

        return $this->render('update', [
            'model' => $model,
            'listaCondominios' => $listaCondominios,
            'listaProprietarios' => $listaProprietarios,
        ]);
    }

    // Apaga uma fração da base de dados
    /**
     * Deletes an existing Fracao model.
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

    // Procura a fração pelo ID e lança erro 404 se não existir
    /**
     * Finds the Fracao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Fracao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fracao::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
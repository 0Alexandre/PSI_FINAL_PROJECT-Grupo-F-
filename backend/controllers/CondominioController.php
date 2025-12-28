<?php

namespace backend\controllers;

use common\models\Condominio;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use Yii;

/**
 * CondominioController implements the CRUD actions for Condominio model.
 */
class CondominioController extends Controller
{
    // Define permissões: 'sysadmin' faz tudo, 'adminCondominio' só pode ver (index/view)
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    // Admin Condominio só pode ver a lista e detalhes
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['sysadmin', 'adminCondominio'],
                    ],
                    // Apenas o Sysadmin pode Criar, Editar ou Apagar Condomínios
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['sysadmin'],
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

    // Lista os condomínios. Se não for 'sysadmin', o utilizador só vê os que gere
    /**
     * Lists all Condominio models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Condominio::find();

        // Se for um admin de condomínio, filtro para mostrar apenas os dele
        if (!Yii::$app->user->can('sysadmin')) {
            $query->where(['admin_id' => Yii::$app->user->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    // Mostra os detalhes de um condomínio
    /**
     * Displays a single Condominio model.
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

    // Cria um novo condomínio e permite escolher qual o Admin responsável (Apenas Sysadmin)
    /**
     * Creates a new Condominio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Condominio();

        // Busca todos os users que têm o perfil 'ADMIN_CONDOMINIO' para preencher o dropdown
        $admins = User::find()
            ->joinWith('perfil')
            ->where(['perfil.perfil' => 'ADMIN_CONDOMINIO'])
            ->all();

        $listaAdmins = ArrayHelper::map($admins, 'id', 'username');

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'listaAdmins' => $listaAdmins,
        ]);
    }

    // Edita um condomínio existente (Apenas Sysadmin)
    /**
     * Updates an existing Condominio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Carrega novamente a lista de admins para caso se queira trocar o gestor
        $admins = User::find()
            ->joinWith('perfil')
            ->where(['perfil.perfil' => 'ADMIN_CONDOMINIO'])
            ->all();

        $listaAdmins = ArrayHelper::map($admins, 'id', 'username');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'listaAdmins' => $listaAdmins,
        ]);
    }

    // Apaga um condomínio (Apenas Sysadmin)
    /**
     * Deletes an existing Condominio model.
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

    // Procura o modelo pelo ID e lança erro 404 se não existir
    /**
     * Finds the Condominio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Condominio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Condominio::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
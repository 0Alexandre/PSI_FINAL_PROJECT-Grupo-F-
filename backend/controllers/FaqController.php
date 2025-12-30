<?php

namespace backend\controllers;

use common\models\Faq;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Condominio;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use Yii;

/**
 * FaqController implements the CRUD actions for Faq model.
 */
class FaqController extends Controller
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
                        'roles' => ['sysadmin', 'adminCondominio'],
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

    // Lista as FAQs. Se não for Sysadmin, aplica um filtro para mostrar apenas as FAQs dos seus condomínios
    /**
     * Lists all Faq models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Faq::find();

        // Se não for Sysadmin, filtra para ver apenas as FAQs dos seus condomínios
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

    // Exibe os detalhes de uma FAQ específica
    /**
     * Displays a single Faq model.
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

    // Cria uma nova FAQ. O dropdown de condomínios é filtrado: Sysadmin vê tudo, AdminCondominio vê apenas os seus
    /**
     * Creates a new Faq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Faq();

        if (Yii::$app->user->can('sysadmin')) {
            // Sysadmin: Pode criar FAQ para qualquer condomínio
            $condominios = Condominio::find()->all();
        } else {
            // AdminCondominio: Só pode criar FAQ para os SEUS condomínios
            $condominios = Condominio::find()
                ->where(['admin_id' => Yii::$app->user->id])
                ->all();
        }

        $listaCondominios = ArrayHelper::map($condominios, 'id', 'nome');

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
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

    // Edita uma FAQ existente, mantendo a mesma lógica de segurança nos dropdowns que existe no Create
    /**
     * Updates an existing Faq model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Repete a lógica de segurança para o Dropdown na edição
        if (Yii::$app->user->can('sysadmin')) {
            $condominios = Condominio::find()->all();
        } else {
            $condominios = Condominio::find()
                ->where(['admin_id' => Yii::$app->user->id])
                ->all();
        }

        $listaCondominios = ArrayHelper::map($condominios, 'id', 'nome');

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'listaCondominios' => $listaCondominios,
        ]);
    }

    // Apaga uma FAQ da base de dados
    /**
     * Deletes an existing Faq model.
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

    // Procura o modelo pelo ID (Versão Original Simples)
    /**
     * Finds the Faq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Faq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Faq::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
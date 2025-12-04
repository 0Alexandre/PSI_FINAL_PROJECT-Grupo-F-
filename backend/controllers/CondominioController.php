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

/**
 * CondominioController implements the CRUD actions for Condominio model.
 */
class CondominioController extends Controller
{
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
                        'actions' => ['index', 'view'],
                        'roles' => ['sysadmin', 'adminCondominio'],
                    ],

                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete'],
                        'roles' => ['sysadmin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Condominio models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Condominio::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

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

    /**
     * Creates a new Condominio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Condominio();

        // 1. LÓGICA NO CONTROLLER (MVC Correto)
        // Buscar apenas users com perfil ADMIN_CONDOMINIO
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

        // 2. Enviar a lista para a view
        return $this->render('create', [
            'model' => $model,
            'listaAdmins' => $listaAdmins,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // REPETIR A MESMA LÓGICA PARA A EDIÇÃO
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
            'listaAdmins' => $listaAdmins, // <--- AQUI TAMBÉM
        ]);
    }

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

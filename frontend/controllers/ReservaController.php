<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use Yii;
use common\models\Reserva;
use common\models\EspacoComum;
use yii\helpers\ArrayHelper;
use common\models\Fracao;

class ReservaController extends \yii\web\Controller
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
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionDelete($id)
    {
        return $this->render('cancelar');
    }

    public function actionCreate()
    {
        $model = new Reserva();
        $user = Yii::$app->user->identity;
        $meuCondominio = $user->getCondominio();

        if (!$meuCondominio) {
            return $this->redirect(['site/index']);
        }

        $espacos = EspacoComum::find()
            ->where(['condominio_id' => $meuCondominio->id])
            ->all();

        $listaEspacos = ArrayHelper::map($espacos, 'id', 'nome');

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->utilizador_id = $user->id;
                $model->estado = 'Pendente';

                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'listaEspacos' => $listaEspacos,
        ]);
    }


    public function actionIndex()
    {
        $query = Reserva::find();

        $fracao = Yii::$app->user->identity->fracao;

        if ($fracao) {
            $query->joinWith('espaco')
                ->andWhere(['espacos_comuns.condominio_id' => $fracao->condominio_id]);
        } else {
            $query->where('0=1');
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('minhas-reservas');
    }

}

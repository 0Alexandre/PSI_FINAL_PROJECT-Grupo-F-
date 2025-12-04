<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\EspacoComum;
use yii\filters\AccessControl;

class EspacoComumController extends Controller
{
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
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        $meuCondominio = $user->getCondominio();

        if (!$meuCondominio) {
            $espacos = [];
        } else {
            $espacos = EspacoComum::find()
                ->where(['condominio_id' => $meuCondominio->id])
                ->all();
        }

        return $this->render('index', [
            'espacos' => $espacos,
        ]);
    }
}
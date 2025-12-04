<?php

namespace frontend\controllers;

use common\models\Anuncio;
use yii\filters\AccessControl;
use Yii;

class AnuncioController extends \yii\web\Controller
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
            $anuncios = [];
        } else {
            $anuncios = Anuncio::find()
                ->where(['condominio_id' => $meuCondominio->id])
                ->orderBy(['data' => SORT_DESC])
                ->all();
        }

        return $this->render('index', [
            'anuncios' => $anuncios,
        ]);
    }

    public function actionView()
    {
        return $this->render('view');
    }

}

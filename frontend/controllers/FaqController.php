<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Faq;
use yii\filters\AccessControl;

class FaqController extends Controller
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

        $condominio = $user->getCondominio();

        if ($condominio) {
            $condominioId = $condominio->id;
        } else {
            $condominioId = null;
        }

        $faqs = Faq::find()
            ->where(['visivel_publico' => 1])
            ->andWhere([
                'OR',
                ['condominio_id' => null],
                ['condominio_id' => $condominioId]
            ])
            ->all();

        return $this->render('index', [
            'faqs' => $faqs,
        ]);
    }
}
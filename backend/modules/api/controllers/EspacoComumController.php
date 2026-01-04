<?php

namespace backend\modules\api\controllers;

use common\models\EspacoComum;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;

class EspacoComumController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        $condominio = $user->condominio;

        if (!$condominio) {
            return [];
        }

        return EspacoComum::find()
            ->where(['condominio_id' => $condominio->id])
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }
}
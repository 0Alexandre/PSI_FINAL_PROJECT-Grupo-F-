<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;

class CondominioController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
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

        return $condominio;
    }
}
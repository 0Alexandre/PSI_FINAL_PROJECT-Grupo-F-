<?php

namespace backend\modules\api\controllers;

use common\models\Anuncio;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;

class AnuncioController extends Controller
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

        // Verifica qual o condomínio do utilizador logado
        $condominio = $user->getCondominio();

        if (!$condominio) {
            return [];
        }

        return Anuncio::find()
            ->where(['condominio_id' => $condominio->id])
            ->orderBy(['data' => SORT_DESC])
            ->all();
    }
}
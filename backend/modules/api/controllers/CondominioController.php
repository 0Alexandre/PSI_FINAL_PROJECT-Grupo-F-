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
        // 1. Identificar quem está a fazer o pedido
        $user = Yii::$app->user->identity;

        // 2. Buscar o condomínio deste utilizador
        $condominio = $user->getCondominio();

        if (!$condominio) {
            return ['message' => 'Utilizador sem condomínio associado.'];
        }

        // 3. RETORNAR os dados para o Android (JSON)
        return $condominio;
    }
}
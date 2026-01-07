<?php

namespace backend\modules\api\controllers;

use common\models\Fracao;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller; 

class FracaoController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    /**
     * Retorna a listagem de frações pertencentes ao utilizador autenticado.
     * Implementa um filtro de segurança para garantir que um utilizador apenas acede aos seus próprios dados.
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        $minhasFracoes = Fracao::find()
            ->where(['proprietario_id' => $user->id])
            ->all();

        return $minhasFracoes;
    }
}
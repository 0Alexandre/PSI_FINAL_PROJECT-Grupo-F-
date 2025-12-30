<?php

namespace backend\modules\api\controllers;

use common\models\Fracao;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller; // Usamos Controller para filtrar os dados manualmente

class FracaoController extends Controller
{
    // 1. SEGURANÇA: Bloqueia quem não tem token válido na URL
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    // 2. LÓGICA: Mostra apenas as frações que pertencem ao utilizador
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        // Procura na tabela 'fracao' onde o 'proprietario_id' é igual ao ID do utilizador logado
        $minhasFracoes = Fracao::find()
            ->where(['proprietario_id' => $user->id])
            ->all();

        return $minhasFracoes;
    }
}
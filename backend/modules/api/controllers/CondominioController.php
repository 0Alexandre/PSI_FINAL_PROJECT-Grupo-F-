<?php

namespace backend\modules\api\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\QueryParamAuth;
use Yii;

class CondominioController extends ActiveController
{
    public $modelClass = 'common\models\Condominio';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Passo 3 da ficha: Definir o autenticador como QueryParamAuth
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];

        return $behaviors;
    }

    public function actionInfo()
    {
        $user = Yii::$app->user->identity;

        // --- DEBUG: Vamos ver quem é o user ---
        // Se der erro aqui, é porque a relação no model Fracao pode ter outro nome ou a tabela está vazia
        $fracao = \common\models\Fracao::find()->where(['proprietario_id' => $user->id])->one();

        if (!$fracao) {
            return [
                'sucesso' => false,
                'mensagem' => 'Ainda não tens fração associada.',
                'debug' => [
                    'id_do_user_logado' => $user->id,
                    'username_logado' => $user->username,
                    'tabela_fracao' => 'Procurámos na tabela fracao onde user_id = ' . $user->id
                ]
            ];
        }

        $condominio = \common\models\Condominio::findOne($fracao->condominio_id);

        return [
            'sucesso' => true,
            'dados' => [
                'condominio' => $condominio->nome,
                'morada' => $condominio->morada,
                'fracao' => $fracao->codigo,
            ]
        ];
    }
}
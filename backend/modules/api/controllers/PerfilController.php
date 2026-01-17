<?php

namespace backend\modules\api\controllers;

use yii\rest\Controller;
use yii\filters\auth\QueryParamAuth;
use common\models\Perfil;
use Yii;

class PerfilController extends Controller
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
     * Retorna os dados detalhados do perfil
     * pertencentes exclusivamente ao utilizador autenticado.
     */
    public function actionIndex() {
        $user = Yii::$app->user->identity;

        $perfil = Perfil::findOne(['user_id' => $user->id]);

        if (!$perfil) {
            return null;
        }

        return $perfil;
    }

    /**
     * Atualiza as informações de perfil do utilizador. Implementa uma lógica de 
     * "upsert": se o registo de perfil não existir, é criado um novo vinculado ao ID do utilizador.
     */
    public function actionUpdate()
    {
        $user = Yii::$app->user->identity;

        $model = Perfil::findOne(['user_id' => $user->id]);

        if (!$model) {
            $model = new Perfil();
            $model->user_id = $user->id;
        }

        $model->load(Yii::$app->request->getBodyParams(), '');

        if ($model->save()) {
            return $model;
        }

        return $model;
    }

}


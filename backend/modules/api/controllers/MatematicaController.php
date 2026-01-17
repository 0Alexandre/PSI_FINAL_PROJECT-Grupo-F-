<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;

class MatematicaController extends Controller
{
    public function actionRaizdois()
    {
        $resultado = sqrt(2);

        return [
            'raizdois' => $resultado,
        ];
    }
}
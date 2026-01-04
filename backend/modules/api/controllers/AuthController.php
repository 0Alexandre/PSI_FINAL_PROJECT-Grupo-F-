<?php

namespace backend\modules\api\controllers;

use common\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;

class AuthController extends Controller
{
    /**
     * Login: Recebe username e password via POST e devolve o Token
     */
    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::findByUsername($username);

        if ($user && $user->validatePassword($password)) {

            return [
                'token' => $user->auth_key,
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        }

        throw new ForbiddenHttpException('Username ou Password incorretos.');
    }
}
<?php

namespace backend\modules\api\controllers;

use common\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;

class AuthController extends Controller
{
    public function actionLogin()
    {
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        $user = User::findByUsername($username);

        if ($user && $user->validatePassword($password)) {
            $auth = Yii::$app->authManager;
            $roles = $auth->getRolesByUser($user->id);

            if (!isset($roles['proprietario'])) {
                throw new ForbiddenHttpException('Acesso restrito: Apenas proprietários podem entrar na App.');
            }

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
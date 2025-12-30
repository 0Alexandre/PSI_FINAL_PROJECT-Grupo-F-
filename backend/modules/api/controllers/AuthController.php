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
        // 1. Captura os dados enviados pelo Postman (JSON)
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        // 2. Procura o utilizador na BD
        $user = User::findByUsername($username);

        // 3. Valida a password
        if ($user && $user->validatePassword($password)) {

            // Retorna os dados essenciais para o Android guardar
            // O 'token' é a auth_key que já existe na tabela user
            return [
                'token' => $user->auth_key,
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ];
        }

        // Se falhar
        throw new ForbiddenHttpException('Username ou Password incorretos.');
    }
}
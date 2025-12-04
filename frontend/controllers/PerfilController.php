<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Perfil;

class PerfilController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if ($user->perfil) {
            $perfil = $user->perfil;
        } else {
            $perfil = new Perfil();
            $perfil->user_id = $user->id;
        }

        if ($this->request->isPost) {
            if ($perfil->load($this->request->post()) && $perfil->save()) {
                Yii::$app->session->setFlash('success', 'Dados atualizados com sucesso!');
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'user' => $user,
            'perfil' => $perfil,
        ]);
    }

    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Perfil atualizado com sucesso!');

            return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
    }
}
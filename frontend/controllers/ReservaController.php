<?php

namespace frontend\controllers;

use yii\filters\AccessControl;

class ReservaController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCancelar()
    {
        return $this->render('cancelar');
    }

    public function actionCriarReserva()
    {
        return $this->render('criar-reserva');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMinhasReservas()
    {
        return $this->render('minhas-reservas');
    }

}

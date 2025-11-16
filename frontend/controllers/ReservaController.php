<?php

namespace frontend\controllers;

use yii\filters\AccessControl;

class ReservaController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function () {
                    return $this->redirect(['/site/login']);
                },
                'rules' => [

                    // PROPRIETÁRIO — ACESSO PERMITIDO
                    [
                        'allow' => true,
                        'roles' => ['proprietario'],
                        'actions' => [
                            'index',
                            'minhas-reservas',
                            'criar-reserva',
                            'cancelar'
                        ],
                    ],

                    // VISITANTE — NUNCA PODE ACEDER
                    [
                        'allow' => false,
                        'roles' => ['?'], // não autenticado
                    ],

                    // ADMIN_CONDOMINIO E SYS_ADMIN → BLOQUEADOS NO FRONTEND
                    [
                        'allow' => false,
                        'roles' => ['adminCondominio', 'sysadmin'],
                    ],
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

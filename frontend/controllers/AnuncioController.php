<?php

namespace frontend\controllers;

use yii\filters\AccessControl;

class AnuncioController extends \yii\web\Controller
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

                    // PROPRIETÁRIO - permitido
                    [
                        'allow' => true,
                        'roles' => ['proprietario'],
                        'actions' => [
                            'index',
                            'view',
                        ],
                    ],

                    // VISITANTE - proibido
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],

                    // ADMIN E SYSADMIN - proibido
                    [
                        'allow' => false,
                        'roles' => ['admin_condominio', 'sys_admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {
        return $this->render('view');
    }

}

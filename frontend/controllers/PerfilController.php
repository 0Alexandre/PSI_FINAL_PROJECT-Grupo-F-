<?php

namespace frontend\controllers;

use yii\filters\AccessControl;


class PerfilController extends \yii\web\Controller
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
                            'index',     // ver perfil
                            'editar',    // editar perfil
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
                        'roles' => ['adminCondominio', 'sysadmin'],
                    ],
                ],
            ],
        ];
    }

    public function actionEditar()
    {
        return $this->render('editar');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}

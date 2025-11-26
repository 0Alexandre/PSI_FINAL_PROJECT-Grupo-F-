<?php

namespace frontend\controllers;

use Yii; // <--- Importante para usar Yii::$app
use yii\filters\AccessControl;
use yii\web\Controller;

class PerfilController extends Controller
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
                    [
                        'allow' => true,
                        'roles' => ['proprietario'],
                        'actions' => ['index', 'update'],
                    ],
                ],
            ],
        ];
    }

    // Ação para mostrar o perfil
    public function actionIndex()
    {
        // 1. Vai buscar os dados do utilizador logado à BD
        $model = Yii::$app->user->identity;

        // 2. Envia esses dados ($model) para a view 'index'
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    // Ação para processar o formulário de edição
    // Nota: Mudei o nome de 'actionEditar' para 'actionUpdate' porque na View
    // definimos o formulário com 'action' => ['update']
    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;

        // Se o formulário foi submetido (POST) e os dados carregados com sucesso...
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Define uma mensagem de sucesso para aparecer na view
            Yii::$app->session->setFlash('success', 'Perfil atualizado com sucesso!');

            // Redireciona de volta para a página de perfil
            return $this->redirect(['index']);
        }

        // Se houver erro ou não for POST, volta ao index
        return $this->redirect(['index']);
    }
}
<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\EspacoComum;
use yii\filters\AccessControl;

/**
 * EspacoComumController handles the listing of common areas for the frontend.
 */
class EspacoComumController extends Controller
{
    // Define as regras de acesso: Apenas utilizadores autenticados (@) podem ver os espaços
    /**
     * @inheritDoc
     */
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

    // Lista os espaços comuns do condomínio do utilizador logado
    /**
     * Lists all EspacoComum models available for the current user's condominium.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        // Obtém o condomínio associado ao utilizador
        $meuCondominio = $user->getCondominio();

        if (!$meuCondominio) {
            $espacos = [];
        } else {
            // Procura apenas os espaços que pertencem ao ID do condomínio do utilizador
            $espacos = EspacoComum::find()
                ->where(['condominio_id' => $meuCondominio->id])
                ->all();
        }

        return $this->render('index', [
            'espacos' => $espacos,
        ]);
    }
}
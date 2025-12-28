<?php

namespace frontend\controllers;

use common\models\Anuncio;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * AnuncioController handles the read-only actions for announcements in the frontend.
 */
class AnuncioController extends Controller
{
    // Define as regras de acesso: Apenas utilizadores autenticados (@) podem ver os anúncios
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

    // Lista os anúncios do condomínio do utilizador logado, ordenados por data
    /**
     * Lists all Anuncio models for the current user's condominium.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        // Obtém o condomínio associado a este utilizador (através da fração ou relação direta)
        $meuCondominio = $user->getCondominio();

        if (!$meuCondominio) {
            $anuncios = [];
        } else {
            // Procura apenas anúncios onde o condominio_id é igual ao do utilizador
            $anuncios = Anuncio::find()
                ->where(['condominio_id' => $meuCondominio->id])
                ->orderBy(['data' => SORT_DESC])
                ->all();
        }

        return $this->render('index', [
            'anuncios' => $anuncios,
        ]);
    }

    // Mostra os detalhes de um anúncio específico, se pertencer ao condomínio do utilizador
    /**
     * Displays a single Anuncio model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found or user has no access
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
}
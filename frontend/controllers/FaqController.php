<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Faq;
use yii\filters\AccessControl;

/**
 * FaqController handles the FAQ listing for the frontend users.
 */
class FaqController extends Controller
{
    // Define as regras de acesso: Apenas utilizadores autenticados podem ver as FAQs
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

    // Lista as FAQs. Mostra tanto as perguntas gerais (Globais) como as do condomínio do utilizador
    /**
     * Lists all Faq models that are public and relevant to the user's condominium.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        // Tenta obter o condomínio do utilizador atual
        $condominio = $user->getCondominio();

        // Se tiver condomínio, guarda o ID, senão fica null
        if ($condominio) {
            $condominioId = $condominio->id;
        } else {
            $condominioId = null;
        }

        // Procura FAQs que estejam marcadas como 'visíveis' E que sejam:
        // OU Globais (condominio_id IS NULL)
        // OU Específicas deste prédio (condominio_id = ID do utilizador)
        $faqs = Faq::find()
            ->where(['visivel_publico' => 1])
            ->andWhere([
                'OR',
                ['condominio_id' => null],
                ['condominio_id' => $condominioId]
            ])
            ->all();

        return $this->render('index', [
            'faqs' => $faqs,
        ]);
    }
}
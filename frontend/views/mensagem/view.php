<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Mensagens $model */

// Título da Página (usando dados do modelo)
$this->title = $model->assunto;
$this->registerCssFile(Yii::getAlias('@web') . '/css/mensagens.css');
?>

<div class="container py-4 mt-4 fade-in-up" style="max-width: 900px;">

    <!-- BOTÃO VOLTAR -->
    <a href="<?= Url::to(['index']) ?>" class="text-decoration-none text-muted mb-4 d-inline-block fw-bold" style="font-size: 0.9rem;">
        <i class="fas fa-arrow-left me-2"></i> Voltar à Caixa de Entrada
    </a>

    <!-- CARTÃO DE MENSAGEM -->
    <div class="modern-card p-0 overflow-hidden border-0 shadow-lg bg-white rounded-3">

        <!-- CABEÇALHO VISUAL (COM RELEVO) -->
        <div class="bg-light border-bottom p-5 text-center position-relative overflow-hidden">

            <!-- Decoração de Fundo (Círculo subtil) -->
            <div style="position: absolute; top: -60px; right: -60px; width: 200px; height: 200px; background: rgba(16, 185, 129, 0.05); border-radius: 50%;"></div>

            <!-- Avatar Grande -->
            <div class="d-flex justify-content-center mb-3">
                <div class="msg-avatar" style="width: 80px; height: 80px; font-size: 2rem; background: linear-gradient(135deg, #10b981, #3b82f6); color: white; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);">
                    <?= strtoupper(substr($model->remetente ? $model->remetente->username : 'U', 0, 1)) ?>
                </div>
            </div>

            <!-- Assunto -->
            <h2 class="fw-bold text-dark mb-2"><?= Html::encode($model->assunto) ?></h2>

            <!-- Meta-dados (Data e Remetente) -->
            <div class="text-muted d-flex justify-content-center align-items-center gap-3 small mt-3">
                <span class="badge bg-white text-dark border px-3 py-2 rounded-pill fw-normal shadow-sm">
                    <i class="far fa-user me-2 text-success"></i> 
                    De: <strong><?= Html::encode($model->remetente ? $model->remetente->username : 'Desconhecido') ?></strong>
                </span>

                <span class="badge bg-white text-dark border px-3 py-2 rounded-pill fw-normal shadow-sm">
                    <i class="far fa-calendar-alt me-2 text-primary"></i> 
                    <?= Yii::$app->formatter->asDate($model->data_envio, 'long') ?> 
                    às <?= Yii::$app->formatter->asTime($model->data_envio, 'short') ?>
                </span>
            </div>
        </div>

        <!-- CORPO DA MENSAGEM -->
        <div class="p-5">
            <div class="text-dark" style="font-size: 1.05rem; line-height: 1.8; white-space: pre-wrap; font-family: 'Georgia', serif; color: #334155;">
                <?= Html::encode($model->corpo) ?>
            </div>
        </div>

        <!-- RODAPÉ (AÇÕES) -->
        <div class="bg-light p-4 border-top d-flex justify-content-between align-items-center">
            <span class="text-muted small">
                <i class="fas fa-shield-alt me-1"></i> Mensagem Segura do DomusGestLink
            </span>
        </div>

    </div>
</div>
<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Mensagens $model */
/** @var string $remetenteNome */

$this->title = $model->assunto;
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="mb-4">
                <a href="<?= Url::to(['index']) ?>" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm text-light">
                    <i class="fas fa-arrow-left me-2 text-light"></i> Voltar à Caixa de Entrada
                </a>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <div class="card-header bg-light border-0 p-5 text-center position-relative">

                    <div class="mb-3 text-primary">
                        <i class="fas fa-user-circle fa-4x"></i>
                    </div>

                    <h2 class="fw-bold text-dark mb-3"><?= Html::encode($model->assunto) ?></h2>

                    <div class="d-flex justify-content-center flex-wrap gap-2">
                        <span class="badge bg-white text-dark border rounded-pill py-2 px-3 shadow-sm fw-normal">
                            <i class="far fa-user me-2 text-success"></i>
                            De: <strong><?= Html::encode($remetenteNome) ?></strong>
                        </span>

                        <span class="badge bg-white text-dark border rounded-pill py-2 px-3 shadow-sm fw-normal">
                            <i class="far fa-clock me-2 text-primary"></i>
                            <?= Yii::$app->formatter->asDate($model->data_envio, 'long') ?>
                            às
                            <?= Yii::$app->formatter->asTime($model->data_envio, 'short') ?>
                        </span>
                    </div>
                </div>

                <div class="card-body p-5">
                    <div class="text-secondary" style="font-size: 1.1rem; line-height: 1.8; white-space: pre-wrap;">
                        <?= Html::encode($model->corpo) ?>
                    </div>
                </div>

                <div class="card-footer bg-transparent border-top p-4 d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        <i class="fas fa-shield-alt me-1 text-success"></i> Mensagem Segura
                    </span>
                </div>

            </div>

        </div>
    </div>
</div>
<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var common\models\Mensagem $model */
/** @var common\models\User[] $destinatarios */

$this->title = 'Nova Mensagem';
$this->registerCssFile(Yii::getAlias('@web') . '/css/mensagens.css');
?>

<div class="container py-4 mt-4 fade-in-up" style="max-width: 800px;">

    <!-- 1. CABEÇALHO -->
    <div class="mb-4">
        <a href="<?= \yii\helpers\Url::to(['index']) ?>" class="text-decoration-none text-muted small fw-bold">
            <i class="fas fa-arrow-left me-1"></i> Voltar à Caixa de Entrada
        </a>
        <h2 class="fw-bold text-dark mt-2">Escrever Nova Mensagem</h2>
    </div>

    <!-- 2. CARTÃO DO FORMULÁRIO -->
    <div class="modern-card bg-white p-4 p-md-5 rounded-3 shadow-sm border">

        <?php $form = ActiveForm::begin([
            'id' => 'mensagem-form',
            'options' => ['class' => 'needs-validation'],
        ]); ?>

        <div class="row g-4">

            <!-- CAMPO: PARA QUEM? (Dropdown) -->
            <div class="col-12">
                <?= $form->field($model, 'destinatario_id')->dropDownList(
                    ArrayHelper::map($destinatarios, 'id', 'username'), // Cria a lista [id => nome]
                    [
                        'prompt' => 'Selecione o destinatário...',
                        'class' => 'form-select form-control-lg bg-light border-0',
                        'style' => 'font-size: 0.95rem;'
                    ]
                )->label('<i class="fas fa-user me-2 text-success"></i>Para:', ['class' => 'form-label fw-bold text-muted small text-uppercase']) ?>
            </div>

            <!-- CAMPO: ASSUNTO -->
            <div class="col-12">
                <?= $form->field($model, 'assunto')->textInput([
                    'placeholder' => 'Ex: Reunião de Condomínio',
                    'class' => 'form-control form-control-lg bg-light border-0',
                    'style' => 'font-size: 0.95rem;'
                ])->label('<i class="fas fa-heading me-2 text-success"></i>Assunto:', ['class' => 'form-label fw-bold text-muted small text-uppercase']) ?>
            </div>

            <!-- CAMPO: MENSAGEM (TextArea) -->
            <div class="col-12">
                <?= $form->field($model, 'corpo')->textarea([
                    'rows' => 8,
                    'placeholder' => 'Escreva aqui a sua mensagem...',
                    'class' => 'form-control bg-light border-0',
                    'style' => 'resize: none; font-size: 0.95rem;'
                ])->label('<i class="fas fa-align-left me-2 text-success"></i>Mensagem:', ['class' => 'form-label fw-bold text-muted small text-uppercase']) ?>
            </div>

            <!-- BOTÕES DE AÇÃO -->
            <div class="col-12 d-flex justify-content-end gap-2 pt-3 border-top mt-4">
                <a href="<?= \yii\helpers\Url::to(['index']) ?>" class="btn btn-light px-4 rounded-pill fw-bold text-muted">
                    Cancelar
                </a>

                <?= Html::submitButton('<i class="fas fa-paper-plane me-2"></i> Enviar Mensagem', [
                    'class' => 'btn btn-success px-4 rounded-pill fw-bold shadow-sm',
                    'style' => 'background-color: #10b981; border: none;'
                ]) ?>
            </div>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
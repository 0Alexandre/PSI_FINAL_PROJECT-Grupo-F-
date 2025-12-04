<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Mensagens $model */
/** @var common\models\User[] $destinatarios */

$this->title = 'Nova Mensagem';
?>

<div class="container py-5" style="max-width: 800px;">

    <div class="d-flex align-items-center mb-4">
        <a href="<?= Url::to(['index']) ?>" class="btn btn-outline-secondary me-3 rounded-circle shadow-sm" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-arrow-left text-light"></i>
        </a>
        <div>
            <h2 class="fw-bold text-light mb-0">Nova Mensagem</h2>
            <p class="text-light mb-0 small">Preencha os dados abaixo para enviar.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">

            <?php $form = ActiveForm::begin(['id' => 'mensagem-form']); ?>

            <div class="vstack gap-4">

                <div>
                    <?= $form->field($model, 'destinatario_id')->dropDownList(
                        ArrayHelper::map($destinatarios, 'id', 'username'),
                        [
                            'prompt' => 'Selecione o destinatário...',
                            'class' => 'form-select form-select-lg bg-light border-0'
                        ]
                    )->label('<i class="fas fa-user me-2 text-primary"></i>Para:', [
                        'class' => 'form-label fw-bold text-secondary small text-uppercase'
                    ]) ?>
                </div>

                <div>
                    <?= $form->field($model, 'assunto')->textInput([
                        'placeholder' => 'Ex: Reunião de Condomínio',
                        'class' => 'form-control form-control-lg bg-light border-0'
                    ])->label('<i class="fas fa-heading me-2 text-primary"></i>Assunto:', [
                        'class' => 'form-label fw-bold text-secondary small text-uppercase'
                    ]) ?>
                </div>

                <div>
                    <?= $form->field($model, 'corpo')->textarea([
                        'rows' => 8,
                        'placeholder' => 'Escreva aqui o conteúdo da sua mensagem...',
                        'class' => 'form-control bg-light border-0',
                        'style' => 'resize: none;'
                    ])->label('<i class="fas fa-align-left me-2 text-primary"></i>Mensagem:', [
                        'class' => 'form-label fw-bold text-secondary small text-uppercase'
                    ]) ?>
                </div>

                <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-2">
                    <a href="<?= Url::to(['index']) ?>" class="btn btn-light px-4 rounded-pill fw-bold text-secondary">
                        Cancelar
                    </a>

                    <?= Html::submitButton('<i class="fas fa-paper-plane me-2"></i> Enviar Mensagem', [
                        'class' => 'btn btn-success px-4 rounded-pill fw-bold shadow-sm'
                    ]) ?>
                </div>

            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
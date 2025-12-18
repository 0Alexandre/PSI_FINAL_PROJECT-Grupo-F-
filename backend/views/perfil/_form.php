<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Perfil $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="perfil-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <label class="form-label">Utilizador Associado (ID)</label>
        <?= Html::textInput('user_display', $model->user_id, [
            'class' => 'form-control',
            'disabled' => true
        ]) ?>
        <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'perfil')->textInput(['maxlength' => true])->label('Perfil') ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'data_nascimento')->input('date') ?>
    </div>

    <div class="mb-3">
        <?= $form->field($model, 'morada')->textarea(['rows' => 3]) ?>
    </div>

    <div class="form-group mt-4 text-end">
        <?= Html::submitButton('<i class="fas fa-save"></i> Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
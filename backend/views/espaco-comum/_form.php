<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\EspacoComum $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="espaco-comum-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'condominio_id')->dropDownList(
        $listaCondominios,
        ['prompt' => 'Selecione o Condomínio...']
    )->label('Publicar no Condomínio') ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

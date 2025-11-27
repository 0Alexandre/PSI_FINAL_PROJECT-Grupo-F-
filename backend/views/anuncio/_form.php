<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Anuncio $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="anuncio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'condominio_id')->textInput() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'conteudo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tipo')->dropDownList([ 'GERAL' => 'GERAL', 'REUNIAO' => 'REUNIAO', 'MANUTENCAO' => 'MANUTENCAO', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'visivel_publico')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

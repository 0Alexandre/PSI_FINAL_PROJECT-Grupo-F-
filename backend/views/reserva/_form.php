<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reserva-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'espaco_id')->textInput() ?>

    <?= $form->field($model, 'utilizador_id')->textInput() ?>

    <?= $form->field($model, 'inicio')->textInput() ?>

    <?= $form->field($model, 'fim')->textInput() ?>

    <?= $form->field($model, 'estado')->dropDownList([ 'PENDENTE' => 'PENDENTE', 'APROVADA' => 'APROVADA', 'REJEITADA' => 'REJEITADA', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

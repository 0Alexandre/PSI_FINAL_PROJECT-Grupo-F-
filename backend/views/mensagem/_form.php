<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Mensagens $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $listaDestinatarios */
?>

<div class="mensagens-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-primary">
        <div class="card-header">Nova Mensagem</div>
        <div class="card-body">

            <?= $form->field($model, 'destinatario_id')->dropDownList(
                $listaDestinatarios,
                ['prompt' => 'Selecione o Destinatário...']
            )->label('Para') ?>

            <?= $form->field($model, 'assunto')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'corpo')->textarea(['rows' => 6]) ?>

        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
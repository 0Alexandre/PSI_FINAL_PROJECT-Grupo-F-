<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Faq $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="faq-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'condominio_id')->textInput() ?>

    <?= $form->field($model, 'pergunta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'resposta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'visivel_publico')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

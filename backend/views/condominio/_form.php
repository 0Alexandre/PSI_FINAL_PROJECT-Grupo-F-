<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper; // 1. Importar o ArrayHelper
use common\models\User;      // 2. Importar o modelo User

/** @var yii\web\View $this */
/** @var common\models\Condominio $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="condominio-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-primary">
        <div class="card-header">Dados do Condomínio</div>
        <div class="card-body">

            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'morada')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'admin_id')->dropDownList(
                $listaAdmins,
                ['prompt' => 'Selecione o Administrador...']
            )->label('Administrador do Prédio') ?>

        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
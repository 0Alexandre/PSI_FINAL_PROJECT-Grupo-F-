<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\Fracao */
/* @var $form yii\widgets\ActiveForm */
/** @var array $listaCondominios */
/** @var array $listaProprietarios */

?>

<div class="fracao-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-warning">
        <div class="card-header">Detalhes da Casa</div>
        <div class="card-body">

            <?= $form->field($model, 'condominio_id')->dropDownList(
                $listaCondominios,
                ['prompt' => 'Selecione o Condomínio...']
            )->label('Pertence ao Condomínio') ?>

            <?= $form->field($model, 'codigo')->textInput(['placeholder' => 'Ex: 3º Esq'])->label('Identificação (Porta)') ?>

            <?= $form->field($model, 'proprietario_id')->dropDownList(
                $listaProprietarios,
                ['prompt' => 'Ainda não tem dono (Vazio)']
            )->label('Proprietário') ?>

        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
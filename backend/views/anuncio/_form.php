<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Anuncio $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $listaCondominios */ //
?>

<div class="anuncio-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Novo Aviso</h3>
        </div>
        <div class="card-body">

            <?= $form->field($model, 'condominio_id')->dropDownList(
                $listaCondominios,
                ['prompt' => 'Selecione o Condomínio...']
            )->label('Publicar no Condomínio') ?>

            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'placeholder' => 'Ex: Elevador em Manutenção']) ?>

            <?= $form->field($model, 'tipo')->dropDownList([
                'GERAL' => 'Informação Geral',
                'REUNIAO' => 'Reunião de Condomínio',
                'MANUTENCAO' => 'Obras / Manutenção',
                'URGENTE' => 'Urgente / Importante',
            ]) ?>

            <?= $form->field($model, 'conteudo')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'visivel_publico')->checkbox(['label' => 'Publicar Imediatamente']) ?>

        </div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Publicar Anúncio', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
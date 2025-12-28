<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Faq $model */
/** @var yii\widgets\ActiveForm $form */
/** @var array $listaCondominios */
?>

<div class="faq-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $opcoes = [];

    if (Yii::$app->user->can('sysadmin')) {
        $opcoes['prompt'] = 'Geral (Visível a todos os condomínios)';
    }
    ?>

    <?= $form->field($model, 'condominio_id')->dropDownList(
        $listaCondominios,
        $opcoes
    )->label('Condomínio Específico') ?>

    <?= $form->field($model, 'pergunta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'resposta')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'visivel_publico')->dropDownList([
        1 => 'Publicado (Visível)',
        0 => 'Rascunho (Oculto)',
    ])->label('Estado') ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
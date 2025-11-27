<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Condominio;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Fracao */
/* @var $form yii\widgets\ActiveForm */

// 1. Lista de Condomínios (Para dizer onde fica a casa)
$condominios = Condominio::find()->all();
$listaCondominios = ArrayHelper::map($condominios, 'id', 'nome');

// 2. Lista de Proprietários (Para dizer de quem é a casa)
$proprietarios = User::find()
    ->joinWith('perfil')
    ->where(['perfil.perfil' => 'PROPRIETARIO']) // Só mostra Proprietários
    ->all();
$listaProprietarios = ArrayHelper::map($proprietarios, 'id', 'username');
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
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'perfil')->dropDownList([
        'PROPRIETARIO' => 'Proprietário',
        'ADMIN_CONDOMINIO' => 'Administrador Condomínio',
        'SYS_ADMIN' => 'SysAdmin',
    ]) ?>
    <?= $form->field($model, 'telefone')->textInput() ?>
    <?= $form->field($model, 'morada')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList([
        10 => 'Ativo',
        9  => 'Inativo',
        0  => 'Apagado'
    ]) ?>

    <?= $form->field($model, 'role')->dropDownList([
        'proprietario' => 'Proprietário',
        'adminCondominio' => 'Admin Condomínio',
        'sysadmin' => 'SysAdmin'
    ], ['prompt' => 'Selecione o papel']) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

</div>

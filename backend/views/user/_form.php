<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var common\models\Perfil $perfil */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados de Conta (Obrigatório)</h3>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'status')->dropDownList([
                        10 => 'Ativo',
                        9  => 'Inativo',
                        0  => 'Banido'
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'role')->dropDownList([
                        'proprietario' => 'Proprietário',
                        'adminCondominio' => 'Admin Condomínio',
                        'sysadmin' => 'SysAdmin'
                    ], ['prompt' => 'Selecione o papel...']) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary mt-3">
        <div class="card-header">
            <h3 class="card-title">Configuração do Perfil</h3>
        </div>
        <div class="card-body">
            <p class="text-muted small">
                <i class="fas fa-info-circle"></i>
                Os dados pessoais (Morada, Telefone, etc.) são geridos pelo próprio utilizador na área de cliente.
            </p>

            <?= $form->field($perfil, 'perfil')->dropDownList([
                'PROPRIETARIO' => 'Proprietário',
                'ADMIN_CONDOMINIO' => 'Admin Condomínio',
                'SYS_ADMIN' => 'SysAdmin'
            ]) ?>

        </div>
    </div>

    <div class="form-group mt-4">
        <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
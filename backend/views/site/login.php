<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login - BackOffice';
$this->registerCssFile(Yii::getAlias('@web') . '/css/login.css');
?>

<div class="login-wrapper">
    <div class="login-box">

        <h1 class="login-title">BackOffice</h1>
        <p class="login-desc">Aceda ao painel administrativo</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')
            ->textInput(['autofocus' => true, 'placeholder' => 'Nome de utilizador'])
            ->label(false) ?>

        <?= $form->field($model, 'password')
            ->passwordInput(['placeholder' => 'Palavra-passe'])
            ->label(false) ?>

        <div class="form-check mb-2">
            <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'form-check-input']) ?>
        </div>

        <?= Html::submitButton('Entrar', ['class' => 'btn-login', 'name' => 'login-button']) ?>

        <?php ActiveForm::end(); ?>

        <div class="login-footer text-center mt-3">
            <small>
                Voltar ao site público:
                <a href="/projeto_final/frontend/web">Frontend</a>
            </small>
        </div>

    </div>
</div>
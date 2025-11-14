<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login - DomusGestLink';

$this->registerCssFile(Yii::getAlias('@web') . '/css/login.css');
?>

<div class="container login-wrapper">
    <div class="login-box">

        <h1 class="login-title">Entrar</h1>
        <p class="login-desc">Aceda à sua conta do DomusGestLink</p>

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

        <div class="login-footer mt-3 text-center">
            <small>
                Esqueceu a palavra-passe?
                <?= Html::a('Recuperar', ['site/request-password-reset']) ?><br>

                Ainda não tem conta?
                <?= Html::a('Criar Conta', ['site/signup']) ?>
            </small>
        </div>

    </div>
</div>

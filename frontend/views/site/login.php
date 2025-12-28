<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login - DomusGestLink';

$this->registerCssFile(Yii::getAlias('@web') . '/css/login.css');
?>

<div class="container login-wrapper d-flex justify-content-center align-items-center mt-5">

    <div class="login-box w-100" style="max-width: 400px;">

        <div class="text-center mb-4">
            <h1 class="login-title text-light">Entrar</h1>
            <p class="login-desc text-light">Aceda à sua conta do DomusGestLink</p>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')
            ->textInput(['autofocus' => true, 'placeholder' => 'Nome de utilizador', 'class' => 'form-control form-control-lg'])
            ->label(false) ?>

        <?= $form->field($model, 'password')
            ->passwordInput(['placeholder' => 'Palavra-passe', 'class' => 'form-control form-control-lg'])
            ->label(false) ?>

        <div class="form-check mb-3">
            <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'form-check-input']) ?>
        </div>

        <div class="d-grid gap-2">
            <?= Html::submitButton('Entrar', ['class' => 'btn btn-primary btn-lg btn-login', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="login-footer mt-4 text-center">
            <small>
                <!--
                Esqueceu a palavra-passe?
                <?= Html::a('Recuperar', ['site/request-password-reset'], ['class' => 'text-decoration-none']) ?><br>
                -->

                Ainda não tem conta?
                <?= Html::a('Criar Conta', ['site/signup'], ['class' => 'text-decoration-none fw-bold']) ?>
            </small>
        </div>

    </div>
</div>
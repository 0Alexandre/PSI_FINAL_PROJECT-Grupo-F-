<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Criar Conta';
$this->registerCssFile(Yii::getAlias('@web') . '/css/signup.css'); // CSS externo
?>

<div class="container signup-wrapper">

    <div class="signup-box">

        <h1 class="signup-title">Criar Conta</h1>
        <p class="signup-desc">Registe-se para aceder ao DomusGestLink</p>

        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')
            ->textInput(['placeholder' => 'Nome de utilizador', 'autofocus' => true])
            ->label(false) ?>

        <?= $form->field($model, 'email')
            ->textInput(['placeholder' => 'Email'])
            ->label(false) ?>

        <?= $form->field($model, 'password')
            ->passwordInput(['placeholder' => 'Palavra-passe'])
            ->label(false) ?>

        <?= Html::submitButton('Criar Conta', [
            'class' => 'btn-signup',
            'name' => 'signup-button'
        ]) ?>

        <?php ActiveForm::end(); ?>

        <div class="signup-footer mt-3 text-center">
            <small>
                Já tem conta?
                <?= Html::a('Iniciar Sessão', ['site/login']) ?>
            </small>
        </div>

    </div>
</div>
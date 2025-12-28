<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Alterar Password';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-change-password">

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 text-secondary">
                        <i class="fas fa-user-lock me-2"></i> Segurança da Conta
                    </h5>
                </div>

                <div class="card-body p-4">

                    <p class="text-muted small mb-4">
                        Para sua segurança, escolha uma password forte. Após a alteração, poderá ser necessário fazer login novamente.
                    </p>

                    <?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>

                    <div class="mb-3">
                        <?= $form->field($model, 'currentPassword', [
                            'inputTemplate' => '<div class="input-group"><span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-key"></i></span>{input}</div>',
                        ])->passwordInput([
                            'class' => 'form-control border-start-0',
                            'placeholder' => 'Digite a password atual'
                        ])->label('Password Atual', ['class' => 'form-label fw-bold text-uppercase small text-muted']) ?>
                    </div>

                    <div class="mb-3">
                        <?= $form->field($model, 'newPassword', [
                            'inputTemplate' => '<div class="input-group"><span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-lock"></i></span>{input}</div>',
                        ])->passwordInput([
                            'class' => 'form-control border-start-0',
                            'placeholder' => 'Nova password'
                        ])->label('Nova Password', ['class' => 'form-label fw-bold text-uppercase small text-muted']) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'repeatPassword', [
                            'inputTemplate' => '<div class="input-group"><span class="input-group-text bg-light text-muted border-end-0"><i class="fas fa-check-circle"></i></span>{input}</div>',
                        ])->passwordInput([
                            'class' => 'form-control border-start-0',
                            'placeholder' => 'Confirme a nova password'
                        ])->label('Repetir Password', ['class' => 'form-label fw-bold text-uppercase small text-muted']) ?>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= Url::home() ?>" class="text-decoration-none text-muted">
                            <i class="fas fa-arrow-left me-1"></i> Voltar ao Painel
                        </a>

                        <?= Html::submitButton('<i class="fas fa-save me-2"></i> Gravar Alterações', [
                            'class' => 'btn btn-success px-4 fw-bold shadow-sm'
                        ]) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>

        </div>
    </div>
</div>
<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Alterar Password';
?>

<div class="site-change-password d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="col-md-6 col-lg-4">

        <div class="card border-0 shadow-lg rounded-4 p-4">
            <div class="card-body">

                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark"><?= Html::encode($this->title) ?></h3>
                    <p class="text-muted small">Defina uma nova palavra-passe segura.</p>
                </div>

                <?php $form = ActiveForm::begin(['id' => 'change-password-form']); ?>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase text-muted" style="letter-spacing: 1px;">Atual</label>
                    <?= $form->field($model, 'currentPassword')->passwordInput([
                        'class' => 'form-control form-control-lg bg-light border-0',
                        'placeholder' => '••••••'
                    ])->label(false) ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase text-muted" style="letter-spacing: 1px;">Nova</label>
                    <?= $form->field($model, 'newPassword')->passwordInput([
                        'class' => 'form-control form-control-lg bg-light border-0',
                        'placeholder' => 'Mínimo 6 caracteres'
                    ])->label(false) ?>
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold small text-uppercase text-muted" style="letter-spacing: 1px;">Repetir</label>
                    <?= $form->field($model, 'repeatPassword')->passwordInput([
                        'class' => 'form-control form-control-lg bg-light border-0',
                        'placeholder' => 'Confirme a nova password'
                    ])->label(false) ?>
                </div>

                <div class="d-grid gap-2">
                    <?= Html::submitButton('Atualizar Password', [
                        'class' => 'btn btn-primary btn-lg rounded-3 fw-bold shadow'
                    ]) ?>

                    <a href="<?= Url::home() ?>" class="btn btn-link text-decoration-none text-muted mt-2">
                        Cancelar
                    </a>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>
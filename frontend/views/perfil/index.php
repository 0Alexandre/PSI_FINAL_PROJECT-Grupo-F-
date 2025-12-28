<?php
/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var common\models\Perfil $perfil */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'O Meu Perfil';
$this->registerCssFile(Yii::getAlias('@web') . '/css/perfil.css');
?>

<div class="profile-wrapper fade-in-up mt-3">

    <div class="container" style="max-width: 1000px;">

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow border-0 rounded-3" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?= Yii::$app->session->getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">

            <div class="col-lg-4">
                <div class="card shadow-lg border-0 h-100 rounded-3">
                    <div class="card-body text-center p-5 d-flex flex-column justify-content-center">

                        <div class="mb-3 text-primary profile-icon-shadow">
                            <i class="fas fa-user-circle fa-4x"></i>
                        </div>

                        <h4 class="fw-bold text-dark mb-2"><?= Html::encode($user->username) ?></h4>

                        <div class="mb-4">
                            <span class="badge bg-light text-primary border px-3 py-2 rounded-pill text-uppercase shadow-sm">
                                <?php
                                if ($perfil->perfil) {
                                    echo Html::encode($perfil->perfil);
                                } else {
                                    echo 'Utilizador';
                                }
                                ?>
                            </span>
                        </div>

                        <div class="text-start mt-4">
                            <p class="text-muted mb-3 d-flex align-items-center">
                                <i class="fas fa-envelope me-3 text-primary bg-light p-2 rounded-circle shadow-sm" style="width: 35px; height: 35px; display:flex; justify-content:center; align-items:center;"></i>
                                <?= Html::encode($user->email) ?>
                            </p>

                            <p class="text-muted mb-3 d-flex align-items-center">
                                <i class="fas fa-phone me-3 text-primary bg-light p-2 rounded-circle shadow-sm" style="width: 35px; height: 35px; display:flex; justify-content:center; align-items:center;"></i>
                                <?php
                                if ($perfil->telefone) {
                                    echo Html::encode($perfil->telefone);
                                } else {
                                    echo 'Sem contacto';
                                }
                                ?>
                            </p>

                            <p class="text-muted mb-0 d-flex align-items-center">
                                <i class="fas fa-map-marker-alt me-3 text-primary bg-light p-2 rounded-circle shadow-sm" style="width: 35px; height: 35px; display:flex; justify-content:center; align-items:center;"></i>
                                <?php
                                if ($perfil->morada) {
                                    echo Html::encode($perfil->morada);
                                } else {
                                    echo 'Sem morada';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-lg border-0 h-100 rounded-3">
                    <div class="card-header bg-white border-bottom py-3 rounded-top-3">
                        <h6 class="mb-0 fw-bold text-primary">
                            <i class="fas fa-user-edit me-2"></i> Editar Dados Pessoais
                        </h6>
                    </div>

                    <div class="card-body p-4">
                        <?php $form = ActiveForm::begin(); ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted fw-bold">Username</label>
                                <input type="text" class="form-control bg-light border-0 shadow-sm" value="<?= Html::encode($user->username) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted fw-bold">Email</label>
                                <input type="text" class="form-control bg-light border-0 shadow-sm" value="<?= Html::encode($user->email) ?>" readonly>
                            </div>

                            <div class="col-12"><hr class="text-muted opacity-25 my-3"></div>

                            <div class="col-md-6">
                                <?= $form->field($perfil, 'telefone')->textInput(['placeholder' => '+351...', 'class' => 'form-control shadow-sm'])->label('Telemóvel', ['class' => 'form-label small fw-bold']) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($perfil, 'data_nascimento')->input('date', ['class' => 'form-control shadow-sm'])->label('Data de Nascimento', ['class' => 'form-label small fw-bold']) ?>
                            </div>
                            <div class="col-12">
                                <?= $form->field($perfil, 'morada')->textInput(['placeholder' => 'Rua, Andar, Código Postal', 'class' => 'form-control shadow-sm'])->label('Morada Completa', ['class' => 'form-label small fw-bold']) ?>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <?= Html::submitButton('<i class="fas fa-save me-2"></i> Guardar Alterações', [
                                    'class' => 'btn btn-primary px-4 py-2 shadow fw-bold rounded-pill'
                                ]) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
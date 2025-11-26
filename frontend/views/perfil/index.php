<?php
/** @var yii\web\View $this */
/** @var common\models\User $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Perfil';
$this->registerCssFile(Yii::getAlias('@web') . '/css/perfil.css');
?>

<div class="profile-wrapper fade-in-up">

    <div class="container" style="max-width: 1100px;">

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-4 shadow-sm border-0 rounded-3" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?= Yii::$app->session->getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4 align-items-stretch">

            <div class="col-lg-4">
                <div class="modern-card">
                    <div class="profile-header-compact"></div>
                    <div class="text-center position-relative">
                        <?php
                        $foto = $model->foto_perfil
                            ? Yii::getAlias('@web') . '/uploads/' . $model->foto_perfil
                            : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';
                        ?>
                        <img src="<?= $foto ?>" class="avatar-compact rounded-circle">
                        <h5 class="fw-bold mt-3 mb-1 text-dark"><?= Html::encode($model->username) ?></h5>
                        <span class="badge bg-light text-primary border px-3 py-1 rounded-pill text-uppercase" style="font-size: 0.7rem;">
                            <?= Html::encode($model->perfil) ?>
                        </span>
                    </div>

                    <div class="card-body pt-4 px-4 pb-4">
                        <div class="info-list-item">
                            <div class="info-icon"><i class="fas fa-envelope"></i></div>
                            <div class="text-truncate text-dark small fw-medium"><?= Html::encode($model->email) ?></div>
                        </div>
                        <div class="info-list-item">
                            <div class="info-icon"><i class="fas fa-phone"></i></div>
                            <div class="text-dark small fw-medium"><?= Html::encode($model->telefone ?? '-') ?></div>
                        </div>
                        <div class="info-list-item">
                            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="text-truncate text-dark small fw-medium"><?= Html::encode($model->morada ?? '-') ?></div>
                        </div>
                        <div class="mt-3 pt-3 border-top text-center text-muted small">
                            <i class="far fa-clock me-1"></i> Membro desde <?= date('d/m/Y', $model->created_at) ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="modern-card">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-user-edit me-2 text-primary"></i> Editar Dados Pessoais</h6>
                    </div>

                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-sm">Username</label>
                                <?= $form->field($model, 'username')->textInput(['readonly' => true, 'class' => 'form-control-sm-custom'])->label(false) ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-sm">Email</label>
                                <?= $form->field($model, 'email')->textInput(['readonly' => true, 'class' => 'form-control-sm-custom'])->label(false) ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-sm">Telemóvel</label>
                                <?= $form->field($model, 'telefone')->textInput(['class' => 'form-control-sm-custom', 'placeholder' => '+351...'])->label(false) ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-sm">Data Nascimento</label>
                                <?= $form->field($model, 'data_nascimento')->input('date', ['class' => 'form-control-sm-custom'])->label(false) ?>
                            </div>
                            <div class="col-12">
                                <label class="form-label-sm">Morada Completa</label>
                                <?= $form->field($model, 'morada')->textInput(['class' => 'form-control-sm-custom'])->label(false) ?>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="p-3 rounded-3 bg-light border border-dashed">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-8">
                                            <label class="form-label-sm mb-1">Atualizar Foto</label>
                                            <?= $form->field($model, 'foto_perfil')->fileInput(['class' => 'form-control-sm-custom border-0 p-0 bg-transparent'])->label(false) ?>
                                        </div>
                                        <div class="col-md-4">
                                            <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-compact']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

        </div> </div> </div>
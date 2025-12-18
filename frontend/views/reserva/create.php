<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Reserva $model */
/** @var array $listaEspacos */
$this->title = 'Nova Reserva';
?>

<div class="container mt-3" style="max-width: 600px;">

    <div class="text-center mb-4">
        <h2 class="fw-bold text-light mb-2">
            <i class="fas fa-calendar-plus"></i> Fazer Reserva
        </h2>
        <p class="text-light">Escolha o espaço e o horário pretendido.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">

            <?php $form = ActiveForm::begin(); ?>

            <div class="vstack gap-4">

                <div>
                    <?= $form->field($model, 'espaco_id')->dropDownList(
                        $listaEspacos,
                        [
                            'prompt' => 'Selecione o Espaço...',
                            'class' => 'form-select form-select-lg bg-light border-0'
                        ]
                    )->label('<i class="fas fa-swimming-pool me-2 text-success"></i>Espaço Comum:', [
                        'class' => 'form-label fw-bold text-secondary small text-uppercase'
                    ]) ?>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <?= $form->field($model, 'inicio')->textInput([
                            'type' => 'date',
                            'class' => 'form-control bg-light border-0'
                        ])->label('<i class="fas fa-clock me-1 text-success"></i> Início', [
                            'class' => 'form-label fw-bold text-secondary small text-uppercase'
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($model, 'fim')->textInput([
                            'type' => 'date',
                            'class' => 'form-control bg-light border-0'
                        ])->label('<i class="fas fa-stopwatch me-1 text-danger"></i> Fim', [
                            'class' => 'form-label fw-bold text-secondary small text-uppercase'
                        ]) ?>
                    </div>
                </div>

                <div class="d-grid mt-2">
                    <?= Html::submitButton('Confirmar Reserva', [
                        'class' => 'btn btn-success btn-lg rounded-pill fw-bold shadow-sm'
                    ]) ?>
                </div>

                <div class="text-center">
                    <a href="<?= Url::to(['index']) ?>" class="text-decoration-none text-muted small fw-bold">
                        <i class="fas fa-arrow-left me-1"></i> Cancelar e Voltar
                    </a>
                </div>

            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

    <div class="text-center mt-3">
        <a href="<?= Url::to(['espaco-comum/index']) ?>" class="btn btn-light rounded-pill px-4 py-2 shadow-lg">
            <i class="fas fa-info-circle me-2"></i> Ver Detalhes dos Espaços
        </a>
    </div>

    <div class="text-center mt-4 text-light small opacity-75">
        <i class="fas fa-info-circle me-1"></i> A sua reserva ficará "Pendente" até ser aprovada pelo administrador.
    </div>

</div>
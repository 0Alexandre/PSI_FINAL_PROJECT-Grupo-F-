<?php
/** @var yii\web\View $this */
/** @var common\models\EspacoComum[] $espacos */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper; // Para cortar texto se for muito grande

$this->title = 'Espaços Comuns';
?>

<div class="container mt-5" style="max-width: 1000px;">

    <div class="text-center mb-5">
        <h1 class="text-primary fw-bold text-light  "><i class="fas fa-swimming-pool text-light"></i> Espaços do Condomínio</h1>
        <p class="text-light">Consulte os espaços disponíveis e faça a sua reserva.</p>
    </div>

    <?php if (empty($espacos)): ?>

        <div class="alert alert-warning text-center p-5 shadow-sm rounded-4 border-0">
            <i class="fas fa-search fa-3x mb-3 opacity-50"></i><br>
            <h4 class="alert-heading">Sem Espaços</h4>
            <p class="mb-0">Este condomínio ainda não tem espaços registados para reserva.</p>
        </div>

    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($espacos as $espaco): ?>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">

                        <div class="card-header bg-light text-center py-4 border-0">
                            <i class="fas fa-door-open fa-4x text-secondary opacity-25"></i>
                        </div>

                        <div class="card-body text-center d-flex flex-column">

                            <h4 class="card-title fw-bold text-dark mb-3">
                                <?= Html::encode($espaco->nome) ?>
                            </h4>

                            <p class="card-text text-muted small flex-grow-1">
                                <?= Html::encode(StringHelper::truncate($espaco->descricao, 100)) ?>
                            </p>

                        </div>

                        <div class="card-footer bg-white border-0 pb-4 pt-0 px-4 text-center">
                            <a href="<?= Url::to(['/reserva/create', 'espaco_id' => $espaco->id]) ?>" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                                <i class="fas fa-calendar-plus me-2"></i> Reservar
                            </a>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>
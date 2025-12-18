<?php
/** @var yii\web\View $this */
/** @var common\models\EspacoComum[] $espacos */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Espaços Comuns';
?>

<div class="container mt-4" style="max-width: 1100px;">

    <div class="bg-primary bg-gradient text-white p-5 rounded-4 shadow-sm text-center mb-5 position-relative overflow-hidden">
        <i class="fas fa-building position-absolute opacity-25" style="font-size: 15rem; right: -20px; top: -50px; transform: rotate(-15deg);"></i>

        <h1 class="fw-bold position-relative"><i class="fas fa-swimming-pool me-2"></i> Espaços do Condomínio</h1>
        <p class="lead position-relative mb-4">Conheça as regras, equipamentos e detalhes de cada espaço.</p>

        <a href="<?= Url::to(['/reserva/create']) ?>" class="btn btn-light rounded-pill fw-bold shadow-sm position-relative px-4">
            <i class="fas fa-arrow-left me-2"></i> Voltar para Fazer Reserva
        </a>
    </div>

    <?php if (empty($espacos)): ?>

        <div class="alert alert-light text-center p-5 shadow-sm rounded-4 border">
            <i class="fas fa-search fa-3x mb-3 text-muted opacity-50"></i><br>
            <h4 class="alert-heading text-muted">Sem Espaços Registados</h4>
            <p class="mb-0 text-muted">De momento não existem informações sobre espaços comuns.</p>
        </div>

    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($espacos as $espaco): ?>

                <?php
                $nome = strtolower($espaco->nome);
                $icon = 'fa-door-open';
                $bgClass = 'bg-light';
                $iconColor = 'text-secondary';

                if (str_contains($nome, 'piscina')) {
                    $icon = 'fa-swimming-pool';
                    $iconColor = 'text-info';
                } elseif (str_contains($nome, 'ginásio') || str_contains($nome, 'ginasio')) {
                    $icon = 'fa-dumbbell';
                    $iconColor = 'text-danger';
                } elseif (str_contains($nome, 'festa') || str_contains($nome, 'salão')) {
                    $icon = 'fa-glass-cheers';
                    $iconColor = 'text-warning';
                } elseif (str_contains($nome, 'reunião') || str_contains($nome, 'reuniao')) {
                    $icon = 'fa-briefcase';
                    $iconColor = 'text-primary';
                } elseif (str_contains($nome, 'churrasco') || str_contains($nome, 'bbq')) {
                    $icon = 'fa-fire';
                    $iconColor = 'text-danger';
                }
                ?>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow border-0 rounded-4 hover-lift">

                        <div class="card-header <?= $bgClass ?> text-center py-4 border-0 rounded-top-4">
                            <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm" style="width: 80px; height: 80px;">
                                <i class="fas <?= $icon ?> fa-2x <?= $iconColor ?>"></i>
                            </div>
                        </div>

                        <div class="card-body p-4 d-flex flex-column">
                            <h4 class="card-title fw-bold text-center text-dark mb-3">
                                <?= Html::encode($espaco->nome) ?>
                            </h4>

                            <hr class="w-25 mx-auto border-primary border-2 opacity-50 mb-3">

                            <div class="card-text text-muted text-start flex-grow-1" style="font-size: 0.95rem; line-height: 1.6;">
                                <?= nl2br(Html::encode($espaco->descricao)) ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>
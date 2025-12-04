<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Minhas Reservas';
?>

<div class="container py-5" style="max-width: 900px;">

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-primary mb-0 text-light">
                <i class="fas fa-calendar-alt me-2 text-light"></i> Minhas Reservas
            </h2>
            <p class="text-light mb-0">Consulte o histórico e o estado dos seus pedidos.</p>
        </div>

        <a href="<?= Url::to(['create']) ?>" class="btn btn-success rounded-pill px-4 py-2 shadow-sm fw-bold">
            <i class="fas fa-plus me-2"></i> Nova Reserva
        </a>
    </div>

    <div class="row">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,

            'options' => ['class' => 'row justify-content-center'],
            'itemOptions' => ['class' => 'col-md-6 mb-4'],
            'layout' => "{items}\n<div class='col-12 mt-4'>{pager}</div>",

            'emptyText' => '
            <div class="col-12">
                <div class="alert alert-light text-center p-5 border border-dashed rounded-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3 opacity-50"></i>
                    <h4 class="text-muted">Ainda não tem reservas.</h4>
                    <p class="mb-4">Aproveite os espaços comuns do seu condomínio.</p>
                </div>
            </div>
        ',

            'itemView' => function ($model, $key, $index, $widget) {

                if ($model->estado == 'APROVADA') {
                    $statusClass = 'bg-success';
                    $statusIcon = 'fa-check-circle';
                }
                elseif ($model->estado == 'REJEITADA') {
                    $statusClass = 'bg-danger';
                    $statusIcon = 'fa-times-circle';
                }
                elseif ($model->estado == 'PENDENTE') {
                    $statusClass = 'bg-warning text-dark';
                    $statusIcon = 'fa-hourglass-half';
                }
                else {
                    $statusClass = 'bg-secondary';
                    $statusIcon = 'fa-question-circle';
                }

                if ($model->espaco) {
                    $nomeEspaco = $model->espaco->nome;
                } else {
                    $nomeEspaco = 'Espaço Removido';
                }

                $inicio = Yii::$app->formatter->asDate($model->inicio, 'php:d M Y');

                $fim = Yii::$app->formatter->asTime($model->fim, 'php:d M Y');

                return "
            <div class='card h-100 shadow-sm border-0 rounded-4 hover-shadow transition'>
                <div class='card-body p-4'>
                    
                    <div class='d-flex justify-content-between align-items-start mb-3'>
                        <h5 class='fw-bold text-dark mb-0'>
                            <i class='fas fa-swimming-pool me-2 text-primary opacity-50'></i>
                            {$nomeEspaco}
                        </h5>
                        <span class='badge {$statusClass} rounded-pill d-flex align-items-center gap-1'>
                            <i class='fas {$statusIcon}'></i> {$model->estado}
                        </span>
                    </div>

                    <div class='vstack gap-2 border-start border-3 ps-3 border-light'>
                        <div>
                            <small class='text-muted text-uppercase fw-bold' style='font-size: 0.7rem;'>Início</small>
                            <div class='text-dark'>{$inicio}</div>
                        </div>
                        <div>
                            <small class='text-muted text-uppercase fw-bold' style='font-size: 0.7rem;'>Fim</small>
                            <div class='text-dark'>até {$fim}</div>
                        </div>
                    </div>

                </div>
            </div>
            ";
            },
        ]) ?>
    </div>

</div>
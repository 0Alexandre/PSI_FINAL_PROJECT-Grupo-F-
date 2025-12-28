<?php
/** @var yii\web\View $this */
/** @var common\models\Anuncio[] $anuncios */

use yii\helpers\Html;

$this->title = 'Quadro de Avisos';
?>

<div class="container mt-3">

    <div class="text-center mb-5">
        <h1 class="text-primary fw-bold text-light"><i class="fas fa-bullhorn text-light"></i> Quadro de Avisos</h1>
        <p class="text-light">Fique a par das últimas novidades do seu condomínio.</p>
    </div>

    <?php if (empty($anuncios)): ?>

        <div class="alert alert-info text-center p-5 shadow-sm rounded-3">
            <i class="fas fa-inbox fa-3x mb-3 text-info"></i><br>
            <h4 class="alert-heading">Sem novidades!</h4>
            <p>Não há avisos para mostrar neste momento.</p>
        </div>

    <?php else: ?>

        <div class="d-flex flex-column gap-4">
            <?php foreach ($anuncios as $anuncio): ?>

                <?php
                $estilo = match($anuncio->tipo) {
                    'URGENTE'    => ['border' => 'border-danger', 'icon' => 'fa-exclamation-triangle', 'text' => 'text-danger', 'bg' => 'bg-danger-subtle'],
                    'REUNIAO'    => ['border' => 'border-primary', 'icon' => 'fa-users', 'text' => 'text-primary', 'bg' => 'bg-primary-subtle'],
                    'MANUTENCAO' => ['border' => 'border-warning', 'icon' => 'fa-tools', 'text' => 'text-warning', 'bg' => 'bg-warning-subtle'],
                    default      => ['border' => 'border-secondary', 'icon' => 'fa-info-circle', 'text' => 'text-secondary', 'bg' => 'bg-light'],
                };
                ?>

                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 border-bottom-0 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle p-2 me-3 <?= $estilo['bg'] ?> <?= $estilo['text'] ?>">
                                <i class="fas <?= $estilo['icon'] ?> fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark"><?= Html::encode($anuncio->titulo) ?></h5>
                                <span class="badge rounded-pill <?= $estilo['bg'] ?> <?= $estilo['text'] ?> border border-0">
                                    <?= Html::encode($anuncio->tipo) ?>
                                </span>
                            </div>
                        </div>
                        <small class="text-muted text-end">
                            <i class="far fa-clock me-1"></i>
                            <?= Yii::$app->formatter->asRelativeTime($anuncio->data) ?>
                        </small>
                    </div>

                    <div class="card-body pt-0 ps-5 ms-2">
                        <div class="text-dark opacity-75" style="line-height: 1.6;">
                            <?= Yii::$app->formatter->asNtext($anuncio->conteudo) ?>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
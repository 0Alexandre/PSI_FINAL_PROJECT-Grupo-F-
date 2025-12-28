<?php
use yii\helpers\Html;

$this->title = 'Perguntas Frequentes';
?>

<div class="container mt-4">
    <div class="text-center mb-5">
        <h1 class="display-6 fw-bold text-white">
            <i class="fas fa-question-circle"></i> Perguntas Frequentes
        </h1>
        <p class="text-light">Clique nas perguntas para ver as respostas. Pode abrir várias ao mesmo tempo.</p>
    </div>

    <?php if (empty($faqs)): ?>
        <div class="alert alert-light text-center shadow-sm border">
            <i class="fas fa-info-circle text-info me-2"></i> Não existem perguntas disponíveis de momento.
        </div>
    <?php else: ?>

        <div class="accordion">
            <?php foreach ($faqs as $faq): ?>
                <div class="accordion-item mb-3 border rounded overflow-hidden shadow-sm">

                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?= $faq->id ?>" aria-expanded="false">

                            <?php if ($faq->condominio_id === null): ?>
                                <span class="badge bg-info text-dark me-3 rounded-pill">
                                    <i class="fas fa-globe me-1"></i> Geral
                                </span>
                            <?php else: ?>
                                <span class="badge bg-success me-3 rounded-pill">
                                    <i class="fas fa-building me-1"></i> Condomínio
                                </span>
                            <?php endif; ?>

                            <?= Html::encode($faq->pergunta) ?>
                        </button>
                    </h2>

                    <div id="faq-<?= $faq->id ?>" class="accordion-collapse collapse">
                        <div class="accordion-body bg-light text-secondary">
                            <?= Yii::$app->formatter->asNtext($faq->resposta) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
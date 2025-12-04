<?php
use yii\helpers\Html;
$this->title = 'Perguntas Frequentes';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4 text-primary text-light"><i class="fas fa-question-circle text-light"></i> FAQ</h1>

    <?php if (empty($faqs)): ?>
        <div class="alert alert-info text-center">Sem perguntas disponíveis.</div>
    <?php else: ?>
        <div class="accordion" id="faqAccordion">
            <?php foreach ($faqs as $faq): ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?= $faq->id ?>">

                            <?php if ($faq->condominio_id === null): ?>
                                <span class="badge bg-secondary me-2">Geral</span>
                            <?php else: ?>
                                <span class="badge bg-success me-2">Do meu Condominio</span>
                            <?php endif; ?>

                            <?= Html::encode($faq->pergunta) ?>
                        </button>
                    </h2>
                    <div id="faq-<?= $faq->id ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?= Yii::$app->formatter->asNtext($faq->resposta) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
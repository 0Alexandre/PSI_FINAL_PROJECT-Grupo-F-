<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;

/** @var common\models\Anuncio[] $anuncios */


$this->title = 'DomusGestLink - Anuncios/Avisos';
?>

<div class="container mt-5">
    <h1>Quadro de Avisos</h1>
    <hr>

    <?php if (empty($anuncios)): ?>
        <p>Não há avisos para mostrar.</p>
    <?php else: ?>

        <?php foreach ($anuncios as $anuncio): ?>

            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; border-radius: 5px;">

                <h3>
                    <?= $anuncio->titulo ?>
                    <small style="color: grey; font-size: 14px;">(<?= $anuncio->tipo ?>)</small>
                </h3>

                <p style="font-size: 12px; color: #888;">
                    Publicado em: <?= Yii::$app->formatter->asDatetime($anuncio->data) ?>
                </p>

                <p><?= Yii::$app->formatter->asNtext($anuncio->conteudo) ?></p>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>
</div>

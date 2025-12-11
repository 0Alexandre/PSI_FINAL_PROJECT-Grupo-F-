<?php
/** @var yii\web\View $this */
/** @var common\models\Fracao|null $minhaFracao */
/** @var common\models\Condominio|null $meuCondominio */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'DomusGestLink - Dashboard';
?>

<?php if (Yii::$app->user->isGuest): ?>

    <section class="hero-section">
        <div class="hero-content">
            <img src="<?= Yii::getAlias('@web') ?>/images/logo.png" alt="DomusGestLink" class="hero-logo" />
            <h1 class="hero-title">Gestão Moderna e Eficiente</h1>
            <p class="hero-subtitle">
                Simplifique a administração do seu condomínio com tecnologia e mobilidade.
            </p>
            <a href="<?= Url::to(['site/login']) ?>" class="btn-saiba-mais">Entrar</a>
        </div>
        <div class="scroll-indicator">
            <i class="fa-solid fa-chevron-down"></i>
        </div>
    </section>

    <section class="about-section" id="sobre">
        <div class="container">
            <h2>Sobre o DomusGestLink</h2>
            <p>O DomusGestLink é uma plataforma de gestão de condomínios...</p>
        </div>
    </section>

<?php else: ?>

    <div class="container mt-5 mb-5">

        <?php if (isset($meuCondominio) && $meuCondominio): ?>

            <div class="p-5 mb-4 bg-light rounded-3 shadow-sm border">
                <div class="container-fluid py-3">
                    <h1 class="display-5 fw-bold text-primary">
                        <i class="fas fa-building"></i> <?= Html::encode($meuCondominio->nome) ?>
                    </h1>
                    <p class="col-md-8 fs-4">Olá, <strong><?= Yii::$app->user->identity->username ?></strong>. Bem-vindo a casa.</p>
                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-home"></i> A sua Fração:</h5>
                            <p class="lead"><?= Html::encode($minhaFracao->codigo ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-map-marker-alt"></i> Morada:</h5>
                            <p class="lead"><?= Html::encode($meuCondominio->morada) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
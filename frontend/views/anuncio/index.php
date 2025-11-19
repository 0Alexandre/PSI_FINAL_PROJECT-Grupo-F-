<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'DomusGestLink - Anuncios/Avisos';
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="<?= Yii::getAlias('@web') ?>/images/logo.png" alt="DomusGestLink" class="me-3" />
            <span class="brand-text">DomusGestLink</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <?php if (Yii::$app->user->isGuest): ?>

                    <li class="nav-item"><a class="nav-link" href="#">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sobre">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="#servicos">Funcionalidades</a></li>
                    <li class="nav-item"><a class="nav-link" href="#app">App Mobile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faq">FAQ</a></li>

                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="<?= Url::to(['site/login']) ?>">Login</a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/reserva/index']) ?>">Reservas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/anuncio/index']) ?>">Anuncios</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/.../index']) ?>">Mensagens</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= Url::to(['/perfil/index']) ?>">O Meu Perfil</a>
                    </li>

                    <li class="nav-item">
                        <?= Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Logout',
                            ['class' => 'nav-link btn btn-link fw-bold logout']
                        )
                        . Html::endForm()
                        ?>
                    </li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<section class="hero-section">
    <h1>Anuncios/Avisos</h1>
</section>
<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'DomusGestLink - Reserva';

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

<!-- SEÇÃO 1: Hero & Ação Principal -->
<section class="hero-section text-center text-md-start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold">Reservas de Espaços Comuns</h1>
                <p class="lead text-muted">Verifique as suas reservas e efetue novas marcações de forma rápida e simples.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <?= Html::a(
                    '<i class="bi bi-calendar-plus"></i> Nova Reserva',
                    ['create'],
                    ['class' => 'btn btn-primary btn-lg px-4 shadow-sm']
                ) ?>
            </div>
        </div>
    </div>
</section>

<div class="container pb-5">

    <!-- SEÇÃO 2: Minhas Reservas (Tabela) -->
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="mb-3 border-bottom pb-2">Minhas Reservas</h3>
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4">Data</th>
                                <th scope="col">Espaço</th>
                                <th scope="col">Estado</th>
                                <th scope="col" class="text-end pe-4">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($minhasReservas)): ?>
                                <?php foreach ($minhasReservas as $reserva): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-secondary"><?= Html::encode($reserva['data']) ?></td>
                                        <td><?= Html::encode($reserva['espaco']) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $reserva['class'] ?> badge-status rounded-pill">
                                                <?= Html::encode($reserva['estado']) ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <?= Html::a('Detalhes', ['view', 'id' => $reserva['id']], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Ainda não tens reservas efetuadas.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Espaços Disponíveis  -->
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4 border-bottom pb-2">Espaços Disponíveis</h3>
        </div>

        <?php foreach ($espacosDisponiveis as $espaco): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm card-space">
                    <!-- Placeholder para Imagem -->
                    <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 160px;">
                        <span class="text-muted"><i class="bi bi-image"></i> Imagem do Espaço</span>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title fw-bold"><?= Html::encode($espaco['nome']) ?></h5>
                        <p class="card-text text-muted small mb-3"><?= Html::encode($espaco['desc']) ?></p>

                        <ul class="list-unstyled mb-4 small">
                            <li class="mb-1"><i class="bi bi-people-fill me-2 text-primary"></i>Capacidade: <strong><?= $espaco['cap'] ?> pessoas</strong></li>
                            <li><i class="bi bi-clock-fill me-2 text-primary"></i>Horário: <strong><?= $espaco['horario'] ?></strong></li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-0 pb-3">
                        <?= Html::a('Reservar', ['create', 'espaco' => $espaco['nome']], ['class' => 'btn btn-outline-dark w-100']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<section class="hero-section">
    <h1>Reservas</h1>
</section>
<?php
/** @var yii\web\View $this */
/** @var common\models\Fracao|null $minhaFracao */
/** @var common\models\Condominio|null $meuCondominio */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'DomusGestLink - Gestão de Condomínios';
?>

<?php if (Yii::$app->user->isGuest): ?>

    <section class="hero-section">
        <div class="hero-content">
            <img src="<?= Yii::getAlias('@web') ?>/images/logo.png" alt="DomusGestLink" class="hero-logo" />
            <h1 class="hero-title">Gestão Moderna e Eficiente</h1>
            <p class="hero-subtitle">
                Simplifique a administração do seu condomínio com tecnologia e mobilidade.
            </p>
            <a href="<?= Url::to(['site/login']) ?>" class="btn-saiba-mais">Entrar na App</a>
        </div>
        <div class="scroll-indicator">
            <i class="fa-solid fa-chevron-down"></i>
        </div>
    </section>

    <section class="about-section" id="sobre">
        <div class="container">
            <h2>Sobre o DomusGestLink</h2>
            <p>
                O DomusGestLink é uma plataforma de gestão de condomínios desenvolvida por estudantes
                do Politécnico de Leiria. Permite aos administradores e proprietários gerir frações,
                reservas, anúncios e muito mais — tanto no site quanto na app mobile.
            </p>
        </div>
    </section>

    <section class="features-section" id="servicos">
        <div class="container">
            <h2 class="section-title">Funcionalidades Principais</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-building"></i>
                        <h5>Gestão de Condomínios</h5>
                        <p>Controle frações, proprietários e espaços comuns com facilidade e segurança.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-calendar-check"></i>
                        <h5>Reservas Online</h5>
                        <p>Reserve espaços comuns em tempo real, diretamente do site ou app mobile.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fas fa-bullhorn"></i>
                        <h5>Anúncios e Avisos</h5>
                        <p>Receba comunicados importantes e mantenha-se atualizado com o seu condomínio.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="app-section" id="app">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start mb-4 mb-md-0">
                    <h2>Aplicação Móvel</h2>
                    <p>
                        Aceda rapidamente às informações do seu condomínio através da aplicação DomusGestLink,
                        disponível para Android e iOS. Faça reservas, leia comunicados e receba notificações
                        instantâneas.
                    </p>
                    <button class="btn-app">
                        <i class="fa-brands fa-google-play me-2"></i>Em breve na Play Store
                    </button>
                    <br />
                    <button class="btn-app mt-3">
                        <i class="fa-brands fa-apple me-2"></i>Em breve na App Store
                    </button>
                </div>
                <div class="col-md-6 text-center">
                    <img src="<?= Yii::getAlias('@web') ?>/images/logo_completo.png" alt="App DomusGestLink" class="app-mockup img-fluid" />
                </div>
            </div>
        </div>
    </section>

    <section class="faq-section" id="faq">
        <div class="container">
            <h2 class="mb-5">Perguntas Frequentes</h2>
            <div class="faq-item">
                <h5>O que é o DomusGestLink?</h5>
                <p>É uma plataforma digital para gestão e comunicação de condomínios, disponível na web e app mobile.</p>
            </div>
            <div class="faq-item">
                <h5>Quem pode utilizar?</h5>
                <p>Administradores, proprietários e inquilinos registados no sistema.</p>
            </div>
            <div class="faq-item">
                <h5>Preciso instalar algo?</h5>
                <p>Sim, existe uma aplicação mobile complementar para Android e iOS — ideal para receber notificações e aceder rapidamente.</p>
            </div>
        </div>
    </section>

<?php else: ?>

    <div class="container mt-5">

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

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-success">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-plus fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Reservas</h5>
                            <p class="card-text">Reserve a piscina, churrasqueira ou salão de festas.</p>
                            <a href="<?= Url::to(['/reserva/create']) ?>" class="btn btn-success w-100">Fazer Reserva</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-info">
                        <div class="card-body text-center">
                            <i class="fas fa-bullhorn fa-3x text-info mb-3"></i>
                            <h5 class="card-title">Avisos</h5>
                            <p class="card-text">Consulte os comunicados do administrador.</p>
                            <a href="<?= Url::to(['/anuncio/index']) ?>" class="btn btn-info text-white w-100">Ler Avisos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-warning">
                        <div class="card-body text-center">
                            <i class="fas fa-user-circle fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">O Meu Perfil</h5>
                            <p class="card-text">Atualize os seus contactos e foto.</p>
                            <a href="<?= Url::to(['/site/perfil']) ?>" class="btn btn-warning w-100">Editar Dados</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php else: ?>

            <div class="d-flex justify-content-center align-items-center vh-100">
                <div class="alert alert-warning text-center p-5 border border-warning shadow-sm" style="max-width: 600px;">
                    <h1 class="display-3 text-warning mb-3"><i class="fas fa-clock"></i></h1>
                    <h2>Conta em Validação</h2>
                    <p class="lead">A sua conta foi criada com sucesso, mas ainda não está associada a nenhuma fração.</p>
                    <hr>
                    <p>Por favor, aguarde que o <strong>Administrador do Condomínio</strong> associe o seu utilizador à sua casa.</p>
                    <p class="small text-muted">Se isto demorar muito tempo, contacte a administração.</p>
                </div>
            </div>

        <?php endif; ?>

    </div>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
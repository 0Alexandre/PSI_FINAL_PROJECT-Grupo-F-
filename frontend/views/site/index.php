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
                        disponível para Android. Faça reservas, leia comunicados e receba notificações
                        instantâneas.
                    </p>
                    <button class="btn-app">
                        <i class="fa-brands fa-google-play me-2"></i>Em breve na Play Store
                    </button>
                    <br />
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
                <p>Administradores e proprietários registados no sistema.</p>
            </div>
            <div class="faq-item">
                <h5>Preciso instalar algo?</h5>
                <p>Sim, existe uma aplicação mobile complementar para Android — ideal para receber notificações e aceder rapidamente.</p>
            </div>
        </div>
    </section>

<?php else: ?>

    <div class="container py-5 mt-5">

        <?php if (isset($meuCondominio) && $meuCondominio): ?>

            <div class="p-5 mb-4 bg-primary bg-gradient text-white rounded-4 shadow overflow-hidden">
                <div class="container-fluid py-2">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-5 fw-bold">Olá, <?= Html::encode(Yii::$app->user->identity->username) ?> 👋</h1>
                            <p class="fs-4 opacity-75">Bem-vindo a casa.</p>
                            <div class="d-inline-flex align-items-center bg-white text-primary rounded-pill px-3 py-2 mt-3 fw-bold shadow-sm">
                                <?= Html::encode($meuCondominio->nome) ?>
                            </div>
                        </div>
                        <div class="col-md-4 text-end d-none d-md-block">
                            <i class="fas fa-building opacity-25" style="font-size: 10rem; margin-right: -15px;"></i>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mb-3 text-light border-bottom pb-2">Acesso Rápido</h4>
            <div class="row g-4 mb-5">
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="<?= Url::to(['/anuncio/index']) ?>" class="text-decoration-none">
                        <div class="card h-100 text-bg-dark border-0 shadow hover-overlay">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-bullhorn fa-3x mb-3 opacity-50"></i>
                                <h4 class="card-title fw-bold">Comunicados</h4>
                                <p class="card-text opacity-75">Ver avisos e atas.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="<?= Url::to(['/reserva/index']) ?>" class="text-decoration-none">
                        <div class="card h-100 text-bg-success border-0 shadow">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-calendar-check fa-3x mb-3 opacity-50"></i>
                                <h4 class="card-title fw-bold">Reservas</h4>
                                <p class="card-text opacity-75">Agendar espaços.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <a href="<?= Url::to(['/mensagem/index']) ?>" class="text-decoration-none">
                        <div class="card h-100 text-bg-warning border-0 shadow">
                            <div class="card-body text-center p-4 text-white">
                                <i class="fas fa-envelope fa-3x mb-3 opacity-50"></i>
                                <h4 class="card-title fw-bold">Mensagens</h4>
                                <p class="card-text opacity-75">Fale com o admin.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow rounded-4 mb-5">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0 text-secondary">
                        <i class="fas fa-info-circle me-2"></i>Os meus Dados
                    </h5>
                </div>
                <div class="card-body p-4">

                    <div class="row align-items-center mb-4">
                        <div class="col-md-6 mb-3 mb-md-0 text-center text-md-start border-end-md">
                            <span class="text-uppercase text-muted small fw-bold">Fração</span>
                            <div class="display-6 fw-bold text-primary"><?= Html::encode($minhaFracao->codigo ?? 'N/A') ?></div>
                        </div>

                        <div class="col-md-6 text-center text-md-start ps-md-4">
                            <span class="text-uppercase text-muted small fw-bold">Morada</span>
                            <div class="fs-5 text-dark"><?= Html::encode($meuCondominio->morada) ?></div>
                        </div>
                    </div>

                    <?php if ($meuCondominio->latitude && $meuCondominio->longitude): ?>
                        <div class="row">
                            <div class="col-12">

                                <h5 class="mb-3 mt-1 fw-bold text-secondary border-top pt-3">
                                    Localização do Condomínio
                                </h5>

                                <div class="rounded-3 overflow-hidden shadow-sm border position-relative">

                                    <iframe
                                            width="100%"
                                            height="350"
                                            frameborder="0"
                                            scrolling="no"
                                            marginheight="0"
                                            marginwidth="0"
                                            src="https://maps.google.com/maps?q=<?= $meuCondominio->latitude ?>,<?= $meuCondominio->longitude ?>&hl=pt-PT&z=15&output=embed">
                                    </iframe>

                                    <div style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);">
                                        <a href="https://www.google.com/maps/search/?api=1&query=<?= $meuCondominio->latitude ?>,<?= $meuCondominio->longitude ?>"
                                           target="_blank"
                                           class="btn btn-light shadow fw-bold rounded-pill px-4 py-2 border">
                                            <i class="fas fa-location-arrow text-primary me-2"></i> Abrir GPS
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        <?php else: ?>

            <div class="d-flex align-items-center justify-content-center" style="min-height: 60vh;">
                <div class="card border-0 shadow rounded-4" style="max-width: 500px; width: 100%;">
                    <div class="card-body text-center p-5">

                        <div class="mb-4 d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle" style="width: 80px; height: 80px;">
                            <i class="fas fa-user-clock fa-3x"></i>
                        </div>

                        <h3 class="card-title fw-bold mb-3 text-dark">Conta em Validação</h3>

                        <p class="card-text text-muted fs-5">
                            O seu registo foi recebido. <br>
                            Aguarde que o <strong>Administrador</strong> valide o seu acesso.
                        </p>

                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>

<?php endif; ?>
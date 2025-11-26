<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'DomusGestLink - Gestão de Condomínios';
?>

<!-- Hero -->
<section class="hero-section">
    <div class="hero-content">
        <img src="<?= Yii::getAlias('@web') ?>/images/logo.png" alt="DomusGestLink" class="hero-logo" />
        <h1 class="hero-title">Gestão Moderna e Eficiente</h1>
        <p class="hero-subtitle">
            Simplifique a administração do seu condomínio com tecnologia e mobilidade.
        </p>
        <a href="#sobre" class="btn-saiba-mais">Saiba Mais</a>
    </div>
    <div class="scroll-indicator">
        <i class="fa-solid fa-chevron-down"></i>
    </div>
</section>

<!-- Sobre -->
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

<!-- Funcionalidades -->
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

<!-- App Mobile -->
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

<!-- FAQ -->
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

        <a href="<?= Url::to(['site/faq']) ?>" class="btn-ver-mais">Ver mais perguntas</a>
    </div>
</section>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

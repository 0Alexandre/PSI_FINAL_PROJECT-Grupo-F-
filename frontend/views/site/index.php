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

            <div class="row mb-4">
                <div class="col-md-4">
                    <a href="<?= Url::to(['comunicado/index']) ?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm hover-card border-0 bg-primary text-white">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-bullhorn fa-3x mb-3"></i>
                                <h4 class="card-title">Comunicados</h4>
                                <p class="card-text">Veja os últimos avisos e atas de reuniões.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?= Url::to(['reserva/create']) ?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm hover-card border-0 bg-success text-white">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-calendar-plus fa-3x mb-3"></i>
                                <h4 class="card-title">Reservar Espaço</h4>
                                <p class="card-text">Agende o uso da sala de reuniões ou piscina.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?= Url::to(['mensagem/create']) ?>" class="text-decoration-none">
                        <div class="card h-100 shadow-sm hover-card border-0 bg-info text-white">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-envelope-open-text fa-3x mb-3"></i>
                                <h4 class="card-title">Contactar Admin</h4>
                                <p class="card-text">Reporte avarias ou envie mensagens à gestão.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                            <h5 class="fw-bold"><i class="fas fa-bell text-warning me-2"></i> Quadro de Avisos</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Manutenção do Elevador</div>
                                        Próxima terça-feira, das 10h às 12h.
                                    </div>
                                    <span class="badge bg-primary rounded-pill">Novo</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Reunião de Condomínio</div>
                                        Agendada para dia 25/12.
                                    </div>
                                    <span class="badge bg-secondary rounded-pill">Info</span>
                                </li>
                            </ul>
                            <div class="mt-3 text-end">
                                <a href="<?= Url::to(['comunicado/index']) ?>" class="btn btn-sm btn-outline-primary">Ver todos</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                            <h5 class="fw-bold"><i class="fas fa-clock text-success me-2"></i> Próximas Reservas</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-light border text-center">
                                <p class="mb-0 text-muted">Não tem reservas ativas para os próximos dias.</p>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="<?= Url::to(['reserva/index']) ?>" class="btn btn-outline-success">
                                    <i class="fas fa-list"></i> Gerir as minhas reservas
                                </a>
                            </div>
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

    <style>
        .hover-card {
            transition: transform 0.2s;
        }
        .hover-card:hover {
            transform: translateY(-5px);
            cursor: pointer;
            opacity: 0.9;
        }
    </style>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
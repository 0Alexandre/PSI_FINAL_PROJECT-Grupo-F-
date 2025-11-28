<?php
use yii\helpers\Url;
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="<?= Url::to(['/site/index']) ?>" class="brand-link">
        <span class="brand-text font-weight-light">DomusGestLink</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">
                    <?= Yii::$app->user->identity->username ?>
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">

                <li class="nav-item">
                    <a href="<?= Url::to(['/site/index']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if (Yii::$app->user->can('sysadmin')): ?>
                    <li class="nav-header">ADMINISTRAÇÃO DO SISTEMA</li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/user/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Gestão de Utilizadores</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/condominio/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-city"></i>
                            <p>Gestão de Condomínios</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/faq/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>Gerir FAQs</p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if (Yii::$app->user->can('adminCondominio')): ?>
                    <li class="nav-header">GESTÃO DO CONDOMÍNIO</li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/fracao/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-door-open"></i>
                            <p>Frações</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/anuncio/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>Anúncios</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/espaco-comum/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-swimming-pool"></i>
                            <p>Espaços Comuns</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/reserva/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Reservas</p>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>

    </div>
</aside>
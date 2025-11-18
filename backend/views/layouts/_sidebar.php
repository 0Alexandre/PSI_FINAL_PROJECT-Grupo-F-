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


                <!-- DASHBOARD (todos no backend) -->
                <li class="nav-item">
                    <a href="<?= Url::to(['/site/index']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if (Yii::$app->user->can('sysadmin')): ?>
                    <li class="nav-item">
                        <a href="<?= Url::to(['/user/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Gestão de Utilizadores</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link disabled text-muted">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Gestão de Condomínios (em breve)</p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if (Yii::$app->user->can('adminCondominio')): ?>
                    <li class="nav-item">
                        <a href="<?= Url::to(['/condominio/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-building"></i>
                            <p>O Meu Condomínio</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/reservas/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Reservas</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/anuncios/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>Anúncios</p>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>

    </div>
</aside>

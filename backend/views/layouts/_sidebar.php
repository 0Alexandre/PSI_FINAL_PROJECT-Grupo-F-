<?php
use yii\helpers\Url;
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Marca do sistema -->
    <a href="<?= Url::to(['/site/index']) ?>" class="brand-link text-center">
        <span class="brand-text text-light fw-bold">DomusGestLink</span>
    </a>

    <div class="sidebar">

        <!-- Informação do utilizador -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">
                    <?= Yii::$app->user->identity->username ?>
                </a>
            </div>
        </div>

        <!-- MENU -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

                <!-- DASHBOARD -->
                <li class="nav-item">
                    <a href="<?= Url::to(['/site/index']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if (Yii::$app->user->can('sys_admin')): ?>

                    <li class="nav-header">ADMINISTRAÇÃO GLOBAL</li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/user/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Gestão de Utilizadores</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/condominio/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-city"></i>
                            <p>Condomínios</p>
                        </a>
                    </li>

                <?php endif; ?>


                <?php if (Yii::$app->user->can('admin_condominio')): ?>

                    <li class="nav-header">SEU CONDOMÍNIO</li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/fracao/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Frações</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/espaco-comum/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-door-open"></i>
                            <p>Espaços Comuns</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/reserva/index']) ?>" class="nav-link">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Reservas</p>
                        </a>
                    </li>

                <?php endif; ?>

            </ul>
        </nav>

    </div>
</aside>

<?php
use yii\helpers\Url;
use yii\helpers\Html;

// 1. Lógica para detetar a página ativa (Highlight)
// Esta função devolve a classe 'active' se o controlador coincidir
function isItemActive($controllerId)
{
    return Yii::$app->controller->id === $controllerId ? 'active' : '';
}

// 2. Preparar Avatar (Inicial do Nome)
$username = Yii::$app->user->identity->username;
$inicial = strtoupper(substr($username, 0, 1));
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="<?= Url::to(['/site/index']) ?>" class="brand-link">
        <span class="brand-text font-weight-light pl-2">DomusGestLink</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <div class="img-circle elevation-2 d-flex align-items-center justify-content-center bg-primary text-white"
                     style="width: 34px; height: 34px; font-weight: bold; font-size: 18px;">
                    <?= $inicial ?>
                </div>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Html::encode($username) ?></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="<?= Url::to(['/site/index']) ?>" class="nav-link <?= isItemActive('site') ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i> <p>Dashboard</p>
                    </a>
                </li>

                <?php if (Yii::$app->user->can('sysadmin')): ?>
                    <li class="nav-header">ADMINISTRAÇÃO DO SISTEMA</li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/user/index']) ?>" class="nav-link <?= isItemActive('user') ?>">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Utilizadores</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/condominio/index']) ?>" class="nav-link <?= isItemActive('condominio') ?>">
                            <i class="nav-icon fas fa-city"></i>
                            <p>Condomínios</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/faq/index']) ?>" class="nav-link <?= isItemActive('faq') ?>">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>FAQ</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/mensagem/index']) ?>" class="nav-link <?= isItemActive('mensagem') ?>">
                            <i class="nav-icon fas fa-envelope"></i> <p>Mensagens</p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if (Yii::$app->user->can('adminCondominio')): ?>
                    <li class="nav-header">GESTÃO DO CONDOMÍNIO</li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/fracao/index']) ?>" class="nav-link <?= isItemActive('fracao') ?>">
                            <i class="nav-icon fas fa-door-open"></i>
                            <p>Frações / Casas</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/anuncio/index']) ?>" class="nav-link <?= isItemActive('anuncio') ?>">
                            <i class="nav-icon fas fa-bullhorn"></i>
                            <p>Anúncios</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/espaco-comum/index']) ?>" class="nav-link <?= isItemActive('espaco-comum') ?>">
                            <i class="nav-icon fas fa-swimming-pool"></i>
                            <p>Espaços Comuns</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/reserva/index']) ?>" class="nav-link <?= isItemActive('reserva') ?>">
                            <i class="nav-icon fas fa-calendar-check"></i> <p>Reservas</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?= Url::to(['/mensagem/index']) ?>" class="nav-link <?= isItemActive('mensagem') ?>">
                            <i class="nav-icon fas fa-envelope"></i> <p>Mensagens</p>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>

    </div>
</aside>
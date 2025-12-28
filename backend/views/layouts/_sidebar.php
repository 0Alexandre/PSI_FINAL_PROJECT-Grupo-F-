<?php
use yii\helpers\Url;
use yii\helpers\Html;

// 1. Lógica para detetar a página ativa (Highlight)
// Esta função devolve a classe 'active' se o controlador coincidir
function isItemActive($controllerId)
{
    return Yii::$app->controller->id === $controllerId ? 'active' : '';
}

$username = Yii::$app->user->identity->username;
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="<?= Url::to(['/site/index']) ?>" class="brand-link">
        <img src="<?= Yii::getAlias('@web') ?>/images/logo.png"
             alt="Domus Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">DomusGestLink</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-user-circle fa-2x text-light"></i>
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
                        <a href="<?= Url::to(['/perfil/index']) ?>" class="nav-link <?= isItemActive('perfil') ?>">
                            <i class="nav-icon fas fa-id-card"></i> <p>Perfis</p>
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

                <li class="nav-header">MINHA CONTA</li>

                <li class="nav-item">
                    <a href="<?= Url::to(['/site/change-password']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-key"></i> <p>Alterar Password</p>
                    </a>
                </li>

            </ul>
        </nav>

    </div>
</aside>
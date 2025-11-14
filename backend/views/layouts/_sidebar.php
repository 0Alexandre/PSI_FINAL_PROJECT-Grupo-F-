<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="<?= Yii::$app->homeUrl ?>" class="brand-link text-center">
        <i class="fas fa-building fa-lg me-2"></i>
        <span class="brand-text fw-light">DomusGetsLink</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Painel do utilizador -->
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <i class="fas fa-user-circle fa-2x text-white-50"></i>
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?= Yii::$app->user->identity->username ?></a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="<?= \yii\helpers\Url::to(['/site/index']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Utilizadores</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-city"></i>
                        <p>Condomínios</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Reservas</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>Anúncios</p>
                    </a>
                </li>

                <li class="nav-item">
                    <?= \yii\helpers\Html::a('<i class="nav-icon fas fa-sign-out-alt"></i><p>Sair</p>', ['/site/logout'], [
                        'class' => 'nav-link text-danger',
                        'data-method' => 'post'
                    ]) ?>
                </li>
            </ul>
        </nav>
    </div>
</aside>

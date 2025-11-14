<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">
    <!-- Botão para abrir/fechar sidebar -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= Yii::$app->homeUrl ?>" class="nav-link">Início</a>
        </li>
    </ul>

    <!-- Lado direito da navbar -->
    <ul class="navbar-nav ms-auto">
        <?php if (!Yii::$app->user->isGuest): ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle"></i> <?= Yii::$app->user->identity->username ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <?= \yii\helpers\Html::a('<i class="fas fa-sign-out-alt"></i> Terminar Sessão', ['/site/logout'], [
                            'data-method' => 'post',
                            'class' => 'dropdown-item text-danger'
                        ]) ?>
                    </li>
                </ul>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= \yii\helpers\Url::to(['/site/login']) ?>">Login</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

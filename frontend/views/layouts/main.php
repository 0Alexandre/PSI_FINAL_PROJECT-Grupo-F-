<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= Html::encode($this->title) ?></title>
        <link rel="icon" href="<?= Yii::getAlias('@web') ?>/images/logo.png">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>/css/style.css">

        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top"> <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="<?= Url::to(['/site/index']) ?>">
                    <img src="<?= Yii::getAlias('@web') ?>/images/logo.png" alt="DomusGestLink" class="me-3" style="height: 40px;" />
                    <span class="brand-text">DomusGestLink</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">

                        <?php if (Yii::$app->user->isGuest): ?>

                            <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/site/index']) ?>">Início</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/site/index', '#' => 'sobre']) ?>">Sobre</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/site/index', '#' => 'servicos']) ?>">Funcionalidades</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/site/index', '#' => 'app']) ?>">App Mobile</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?= Url::to(['/site/index', '#' => 'faq']) ?>">FAQ</a></li>

                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="<?= Url::to(['site/login']) ?>">Login</a>
                            </li>

                        <?php else: ?>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['/reserva/index']) ?>">Reservas</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['/anuncio/index']) ?>">Anuncios</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['/mensagem/index']) ?>">Mensagens</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= Url::to(['/faq/index']) ?>">FAQ</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle me-1"></i>
                                    <?= Yii::$app->user->identity->username ?>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                    <li>
                                        <a class="dropdown-item" href="<?= Url::to(['site/change-password']) ?>">
                                            <i class="fas fa-key me-2"></i> Alterar Password
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="<?= Url::to(['/perfil/index']) ?>">
                                            <i class="fas fa-id-card me-2"></i> O Meu Perfil
                                        </a>
                                    </li>

                                    <li><hr class="dropdown-divider"></li>

                                    <li>
                                        <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex w-100']) ?>
                                        <?= Html::submitButton(
                                            '<i class="fas fa-sign-out-alt me-2"></i> Sair',
                                            ['class' => 'dropdown-item text-danger', 'style' => 'cursor: pointer;']
                                        ) ?>
                                        <?= Html::endForm() ?>
                                    </li>

                                </ul>
                            </li>

                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-shrink-0">
        <?php
        $isHomePage = Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index';

        if ($isHomePage) {
            $classeCss = 'container-fluid p-0';
        } else {
            $classeCss = 'container mt-5 pt-5';
        }
        ?>

        <div class="<?= $classeCss ?>">
            <?= $content ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
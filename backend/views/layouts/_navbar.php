<?php
use yii\helpers\Html;

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Botão para abrir sidebar -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Lado direito -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item d-flex align-items-center mr-3">
        <span class="text-dark fw-bold">
            <?= Html::encode(Yii::$app->user->identity->username) ?>
        </span>
        </li>

        <li class="nav-item">
            <?= Html::beginForm(['/site/logout'], 'post') ?>
            <?= Html::submitButton(
                'Logout',
                ['class' => 'btn btn-danger btn-sm']
            ) ?>
            <?= Html::endForm() ?>
        </li>

    </ul>
</nav>

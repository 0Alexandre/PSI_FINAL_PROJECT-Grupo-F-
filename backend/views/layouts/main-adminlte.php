<?php
use dmstr\adminlte\web\AdminLteAsset;   // 👈 namespace correto para v3.x
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

AdminLteAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php $this->beginBody() ?>

<div class="wrapper">
    <?= $this->render('_navbar') ?>
    <?= $this->render('_sidebar') ?>

    <div class="content-wrapper p-3">
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs'] ?? []]) ?>
        <?= $content ?>
    </div>

    <?= $this->render('_footer') ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

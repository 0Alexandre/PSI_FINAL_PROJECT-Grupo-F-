<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EspacoComum $model */

$this->title = 'Create Espaco Comum';
$this->params['breadcrumbs'][] = ['label' => 'Espaco Comums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="espaco-comum-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

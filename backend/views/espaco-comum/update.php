<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\EspacoComum $model */

$this->title = 'Update Espaco Comum: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Espaco Comums', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="espaco-comum-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

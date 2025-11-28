<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Condominio $model */

$this->title = 'Update Condominio: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Condominios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="condominio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaAdmins' => $listaAdmins,
    ]) ?>

</div>

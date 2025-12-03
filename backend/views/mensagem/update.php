<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Mensagens $model */

$this->title = 'Atualizar Mensagem ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mensagens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mensagens-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaDestinatarios' => $listaDestinatarios,
    ]) ?>

</div>

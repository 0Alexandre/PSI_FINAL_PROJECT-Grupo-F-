<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Mensagens $model */

$this->title = 'Create Mensagens';
$this->params['breadcrumbs'][] = ['label' => 'Mensagens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensagens-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaDestinatarios' => $listaDestinatarios,
    ]) ?>

</div>

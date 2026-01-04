<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Mensagem $model */

$this->title = 'Create Mensagem';
$this->params['breadcrumbs'][] = ['label' => 'Mensagem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensagens-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaDestinatarios' => $listaDestinatarios,
    ]) ?>

</div>

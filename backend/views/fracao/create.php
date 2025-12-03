<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Fracao $model */

$this->title = 'Create Fracao';
$this->params['breadcrumbs'][] = ['label' => 'Fracaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fracao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
            'model' => $model,
        'listaCondominios' => $listaCondominios,
        'listaProprietarios' => $listaProprietarios,
    ]) ?>

</div>

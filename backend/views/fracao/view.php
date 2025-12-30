<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Fracao $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fracaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fracao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Condomínio',
                'value' => $model->condominio_id . ' - ' . $model->condominio->nome,
            ],
            [
                'label' => 'Proprietário',
                'value' => $model->proprietario_id . ' - ' . $model->proprietario->username,
            ],
            'codigo',
        ],
    ]) ?>

</div>

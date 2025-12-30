<?php

use common\models\Reserva;
use yii\helpers\Html;
use yii\grid\GridView;
use common\grid\ActionColumn;

$this->title = 'Reservas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reserva-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Condomínio',
                'value' => function ($model) {
                    return $model->espaco->condominio->nome;
                },
            ],
            [
                'attribute' => 'espaco_id',
                'value' => function ($model) {
                    return $model->espaco_id . ' - ' . $model->espaco->nome;
                },
            ],
            [
                'attribute' => 'utilizador_id',
                'value' => function ($model) {
                    return $model->utilizador_id . ' - ' . $model->utilizador->username;
                },
            ],
            'inicio',
            'fim',
            ['class' => ActionColumn::class],
        ],
    ]); ?>

</div>
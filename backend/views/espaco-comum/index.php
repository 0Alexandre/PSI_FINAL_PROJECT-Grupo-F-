<?php

use common\models\EspacoComum;
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Espaços Comums';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="espaco-comum-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Espaço Comum', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'condominio_id',
                'label' => 'Condomínio',
                'value' => function ($model) {
                    return $model->condominio_id . ' - ' . $model->condominio->nome;
                },
            ],
            'nome',
            'descricao:ntext',

            ['class' => ActionColumn::class],
        ],
    ]); ?>


</div>

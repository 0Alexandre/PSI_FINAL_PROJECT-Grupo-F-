<?php

use common\models\Anuncio;
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Anuncios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anuncio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Anuncio', ['create'], ['class' => 'btn btn-success']) ?>
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
            'titulo',
            'conteudo:ntext',
            'tipo',
            [
                'attribute' => 'visivel_publico',
                'label' => 'Visível ao Público?',
                'format' => 'boolean',
            ],
            ['class' => ActionColumn::class],
        ],
    ]); ?>


</div>

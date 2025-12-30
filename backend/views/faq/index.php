<?php

use common\models\Faq;
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Faqs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Faq', ['create'], ['class' => 'btn btn-success']) ?>
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
                    if ($model->condominio) {
                        return $model->condominio_id . ' - ' . $model->condominio->nome;
                    }
                    return 'Geral';
                },
            ],
            'pergunta:ntext',
            'resposta:ntext',
            [
                'attribute' => 'visivel_publico',
                'label' => 'Visível ao Público?',
                'format' => 'boolean',
            ],

            ['class' => ActionColumn::class],
        ],
    ]); ?>


</div>

<?php

use common\models\Fracao;
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Frações';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fracao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Fração', ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'proprietario_id',
                'label' => 'Proprietario',
                'value' => function ($model) {
                    return $model->proprietario_id . ' - ' . $model->proprietario->username;
                },
            ],
            'codigo',
            ['class' => ActionColumn::class],
        ],
    ]); ?>


</div>

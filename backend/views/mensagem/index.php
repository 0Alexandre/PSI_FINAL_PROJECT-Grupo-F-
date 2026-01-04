<?php

use common\models\Mensagem;
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mensagem';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensagens-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Mensagem', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'remetente_id',
                'value' => function ($model) {
                    return $model->remetente_id . ' - ' . $model->remetente->username;
                },
            ],
            [
                'attribute' => 'destinatario_id',
                'value' => function ($model) {
                    return $model->destinatario_id . ' - ' . $model->destinatario->username;
                },
            ],
            'assunto',
            'corpo:ntext',

            ['class' => ActionColumn::class],
        ],
    ]); ?>


</div>

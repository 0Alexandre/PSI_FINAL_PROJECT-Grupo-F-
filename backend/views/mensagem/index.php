<?php

use common\models\Mensagens;
use yii\helpers\Html;
use yii\helpers\Url;
use common\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mensagens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mensagens-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Mensagens', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'remetente_id',
            'destinatario_id',
            'assunto',
            'corpo:ntext',

            ['class' => ActionColumn::class],
        ],
    ]); ?>


</div>

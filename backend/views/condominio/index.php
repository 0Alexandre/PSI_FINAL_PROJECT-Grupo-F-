<?php

use common\models\Condominio;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\grid\ActionColumn; // A tua classe personalizada

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Condominios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condominio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Condominio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // Adiciona classes para a tabela ficar bonita (AdminLTE style)
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nome',
            'morada',

            [
                'attribute' => 'admin_id',
                'value' => 'admin.username',
                'label' => 'Administrador',
            ],

            ['class' => ActionColumn::class],
        ],
    ]); ?>

</div>
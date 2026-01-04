<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Mensagem $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mensagem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mensagens-view">

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
                'label' => 'Remetente',
                'value' => $model->remetente_id . ' - ' . $model->remetente->username,
            ],
            [
                'label' => 'Destinatário',
                'value' => $model->destinatario_id . ' - ' . $model->destinatario->username,
            ],

            'assunto',
            'corpo:ntext',
            'data_envio:datetime',
        ],
    ]) ?>

</div>

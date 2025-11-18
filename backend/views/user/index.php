<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Gestão de Utilizadores';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Utilizadores do Sistema</h3>
    </div>

    <div class="card-body">
        <p>
            <?= Html::a('Criar Utilizador', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'username',
                'email',
                'perfil',
                'status',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>

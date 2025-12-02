<?php
use yii\helpers\Html;
use yii\grid\GridView;
use common\grid\ActionColumn; // Importar a tua classe de botões
use common\grid\StatusColumn; // Importar a tua classe de status

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
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'], // CSS Nível 1
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'username',
                'email:email',

                [
                    'attribute' => 'perfil_nome',
                    'value' => 'perfil.perfil',
                    'label' => 'Tipo de Perfil',
                ],

                ['class' => StatusColumn::class],

                // Botões bonitos
                ['class' => ActionColumn::class],
            ],
        ]); ?>
    </div>
</div>
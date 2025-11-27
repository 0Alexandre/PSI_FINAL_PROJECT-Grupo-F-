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
                ['class' => 'yii\grid\SerialColumn'], // Adiciona numeração 1, 2, 3...

                'id',
                'username',
                'email:email',

                // === CORREÇÃO DO PERFIL ===
                [
                    'attribute' => 'perfil_nome', // Usa a variável pública do UserSearch
                    'value' => 'perfil.perfil',   // Vai buscar o valor à relação: tabela perfil -> coluna perfil
                    'label' => 'Tipo de Perfil',
                ],

                // === EXEMPLO DO TELEFONE (Nova Tabela) ===
                [
                    'attribute' => 'telefone',    // Usa a variável pública do UserSearch
                    'value' => 'perfil.telefone', // Vai buscar à relação
                    'label' => 'Telefone',
                ],

                // Opcional: Melhorar visualização do Status
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        return $model->status == 10 ? 'Ativo' : 'Inativo';
                    },
                    'filter' => [10 => 'Ativo', 9 => 'Inativo', 0 => 'Apagado'],
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
<?php

namespace common\grid;

use yii\grid\DataColumn;

class StatusColumn extends DataColumn
{
    // Define qual é o atributo da base de dados
    public $attribute = 'status';

    // Permite HTML (para as etiquetas coloridas funcionarem)
    public $format = 'raw';

    // Alinha o texto ao centro
    public $headerOptions = ['style' => 'text-align: center; width: 120px;'];
    public $contentOptions = ['style' => 'text-align: center; vertical-align: middle;'];

    // 1. O Filtro que aparece no topo da tabela
    public $filter = [
        10 => 'Ativo',
        9  => 'Inativo',
        0  => 'Apagado',
    ];

    // 2. A Lógica que desenha a etiqueta
    protected function renderDataCellContent($model, $key, $index)
    {
        $value = (int)$model->{$this->attribute}; // Força ser número inteiro

        switch ($value) {
            case 10:
                // Verde para Ativo
                return '<span class="badge bg-success" style="font-size: 90%;">Ativo</span>';

            case 9:
                // Amarelo para Inativo
                return '<span class="badge bg-warning text-dark" style="font-size: 90%;">Inativo</span>';

            case 0:
                // Cinzento Escuro para Apagado (O que faltava)
                return '<span class="badge bg-secondary" style="font-size: 90%;">Apagado</span>';

            default:
                // Caso apareça um número estranho
                return '<span class="badge bg-dark">Desc. (' . $value . ')</span>';
        }
    }
}
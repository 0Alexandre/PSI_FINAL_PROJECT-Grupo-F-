<?php

namespace common\grid;

use Yii;
use yii\grid\ActionColumn as YiiActionColumn;
use yii\helpers\Html;

class ActionColumn extends YiiActionColumn
{
    public $header = 'Ações';
    public $headerOptions = ['style' => 'color:#337ab7; width: 130px; text-align: center'];
    public $contentOptions = ['style' => 'text-align: center; vertical-align: middle;'];

    /**
     * Define os botões padrão (View, Update, Delete)
     */
    protected function initDefaultButtons()
    {
        // Agora passamos a classe CSS dentro de um array 'options'
        $this->initDefaultButton('view', 'eye', [
            'class' => 'btn btn-sm btn-info text-white'
        ]);

        $this->initDefaultButton('update', 'pencil-alt', [
            'class' => 'btn btn-sm btn-primary'
        ]);

        $this->initDefaultButton('delete', 'trash', [
            'class' => 'btn btn-sm btn-danger'
        ]);
    }

    /**
     * Cria o botão individualmente.
     * CORREÇÃO: O 3º parâmetro agora chama-se $additionalOptions e é um array, igual ao pai.
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {

            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {

                $title = ucfirst($name);

                // Opções base
                $options = [
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ];

                // Junta as opções base com as opções que passámos (a classe CSS)
                $options = array_merge($options, $additionalOptions);

                // Lógica especial para o botão Delete
                if ($name === 'delete') {
                    $options['data-confirm'] = 'Tem a certeza que pretende eliminar este item?';
                    $options['data-method'] = 'post';
                }

                $icon = Html::tag('span', '', ['class' => "fas fa-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }
}
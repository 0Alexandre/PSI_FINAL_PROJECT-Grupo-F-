<?php

use yii\helpers\Html;
use common\models\User;

/** @var yii\web\View $this */
/** @var common\models\Condominio $model */

$this->title = 'Create Condominio';
$this->params['breadcrumbs'][] = ['label' => 'Condominios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="condominio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listaAdmins' => $listaAdmins,
    ]) ?>

</div>

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Atualizar Utilizador: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model,
        'perfil' => $perfil, // <--- Adiciona esta linha
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>

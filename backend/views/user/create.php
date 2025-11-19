<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Criar Utilizador';
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>

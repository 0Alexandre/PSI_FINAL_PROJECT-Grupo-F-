<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $recebidasProvider */
/** @var yii\data\ActiveDataProvider $enviadasProvider */

$this->title = 'Minhas Mensagem';
?>

<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-light mb-0">
            <i class="fas fa-envelope me-2 text-primary text-light"></i> Mensagens
        </h2>
        <a href="<?= Url::to(['create']) ?>" class="btn btn-success rounded-pill px-4 shadow-sm">
            <i class="fas fa-pen me-2"></i> Escrever Nova
        </a>
    </div>

    <ul class="nav nav-pills mb-3 bg-white p-2 rounded shadow-sm d-inline-flex border" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill" id="pills-inbox-tab" data-bs-toggle="pill" data-bs-target="#pills-inbox" type="button" role="tab">
                <i class="fas fa-inbox me-2"></i> Recebidas
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill" id="pills-sent-tab" data-bs-toggle="pill" data-bs-target="#pills-sent" type="button" role="tab">
                <i class="fas fa-paper-plane me-2"></i> Enviadas
            </button>
        </li>
    </ul>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show active" id="pills-inbox" role="tabpanel">
                <?= ListView::widget([
                    'dataProvider' => $recebidasProvider,
                    'layout' => "<div class='list-group list-group-flush'>{items}</div>\n<div class='p-3 border-top bg-light'>{pager}</div>",
                    'itemOptions' => ['tag' => false],
                    'emptyText' => '<div class="text-center py-5 text-muted"><i class="far fa-envelope-open fa-3x mb-3 opacity-50"></i><br>Não tem mensagens novas.</div>',

                    'itemView' => function ($model) {
                        $url = Url::to(['view', 'id' => $model->id]);

                        if ($model->remetente) {
                            $nome = $model->remetente->username;
                        } else {
                            $nome = 'Utilizador #' . $model->remetente_id;
                        }

                        $data = Yii::$app->formatter->asRelativeTime($model->data_envio);
                        $assunto = Html::encode($model->assunto);

                        return "
                        <a href='{$url}' class='list-group-item list-group-item-action p-3 border-start-0 border-end-0'>
                            <div class='d-flex align-items-center'>
                                <div class='mb-1 text-primary'>
                                    <i class='fas fa-user-circle fa-3x'></i>
                                </div>
                                <div class='flex-grow-1 ms-3'>
                                    <div class='d-flex justify-content-between align-items-center mb-1'>
                                        <h6 class='mb-0 fw-bold text-dark'>{$nome}</h6>
                                        <small class='text-muted'>{$data}</small>
                                    </div>
                                    <p class='mb-0 text-secondary text-truncate' style='max-width: 500px;'>
                                        {$assunto}
                                    </p>
                                </div>
                            </div>
                        </a>";
                    },
                ]) ?>
            </div>

            <div class="tab-pane fade" id="pills-sent" role="tabpanel">
                <?= ListView::widget([
                    'dataProvider' => $enviadasProvider,
                    'layout' => "<div class='list-group list-group-flush'>{items}</div>\n<div class='p-3 border-top bg-light'>{pager}</div>",
                    'itemOptions' => ['tag' => false],
                    'emptyText' => '<div class="text-center py-5 text-muted">Nenhuma mensagem enviada.</div>',

                    'itemView' => function ($model) {
                        $url = Url::to(['view', 'id' => $model->id]);

                        if ($model->destinatario) {
                            $nome = $model->destinatario->username;
                        } else {
                            $nome = 'Utilizador #' . $model->destinatario_id;
                        }

                        $data = Yii::$app->formatter->asDate($model->data_envio, 'php:d/m/Y H:i');
                        $assunto = Html::encode($model->assunto);

                        return "
                        <a href='{$url}' class='list-group-item list-group-item-action p-3 border-start-0 border-end-0'>
                            <div class='d-flex align-items-center'>
                                <div class='mb-1 text-primary'>
                                    <i class='fas fa-user-circle fa-3x'></i>
                                </div>
                                <div class='flex-grow-1 ms-3'>
                                    <div class='d-flex justify-content-between align-items-center mb-1'>
                                        <h6 class='mb-0 text-dark'>Para: <strong>{$nome}</strong></h6>
                                        <small class='text-muted'>{$data}</small>
                                    </div>
                                    <p class='mb-0 text-secondary text-truncate' style='max-width: 500px;'>
                                        {$assunto}
                                    </p>
                                </div>
                            </div>
                        </a>";
                    },
                ]) ?>
            </div>

        </div>
    </div>
</div>
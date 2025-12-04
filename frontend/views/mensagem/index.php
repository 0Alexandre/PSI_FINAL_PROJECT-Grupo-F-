<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $recebidasProvider */
/** @var yii\data\ActiveDataProvider $enviadasProvider */

$this->title = 'Minhas Mensagens';
$this->registerCssFile(Yii::getAlias('@web') . '/css/mensagens.css');
?>

<div class="container py-4 mt-4 fade-in-up" style="max-width: 1000px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-light mb-0">Mensagens</h2>
        <a href="<?= Url::to(['create']) ?>" class="btn btn-success shadow-sm px-4 rounded-pill">
            <i class="fas fa-pen me-2"></i> Escrever Nova
        </a>
    </div>

    <ul class="nav nav-pills mb-4 bg-white p-2 rounded shadow-sm d-inline-flex" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-inbox-tab" data-bs-toggle="pill" data-bs-target="#pills-inbox" type="button" role="tab">
                <i class="fas fa-inbox me-2"></i> Recebidas
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-sent-tab" data-bs-toggle="pill" data-bs-target="#pills-sent" type="button" role="tab">
                <i class="fas fa-paper-plane me-2"></i> Enviadas
            </button>
        </li>
    </ul>

    <div class="tab-content modern-card bg-white rounded-3 shadow-sm overflow-hidden" id="pills-tabContent">

        <div class="tab-pane fade show active" id="pills-inbox" role="tabpanel">
            <?= ListView::widget([
                'dataProvider' => $recebidasProvider,
                'layout' => "{items}\n<div class='p-3 border-top'>{pager}</div>",
                'options' => ['class' => 'msg-list'],
                'itemOptions' => ['tag' => false],
                'emptyText' => '<div class="text-center py-5 text-muted"><i class="far fa-envelope-open fa-3x mb-3"></i><br>Não tem mensagens novas.</div>',

                // HTML DE CADA MENSAGEM RECEBIDA
                'itemView' => function ($model) {
                    $url = Url::to(['view', 'id' => $model->id]);

                    // Tenta obter o nome do remetente (quem enviou)
                    $nome = $model->remetente ? $model->remetente->username : 'Utilizador #' . $model->remetente_id;
                    $inicial = strtoupper(substr($nome, 0, 1));
                    $data = Yii::$app->formatter->asRelativeTime($model->data_envio);

                    return "
                    <a href='{$url}' class='msg-item'>
                        <div class='msg-avatar'>{$inicial}</div>
                        <div class='msg-info'>
                            <div class='msg-top'>
                                <span class='msg-name'>{$nome}</span>
                                <span class='msg-date'>{$data}</span>
                            </div>
                            <div class='msg-subject'>" . Html::encode($model->assunto) . "</div>
                        </div>
                    </a>";
                },
            ]) ?>
        </div>

        <div class="tab-pane fade" id="pills-sent" role="tabpanel">
            <?= ListView::widget([
                'dataProvider' => $enviadasProvider,
                'layout' => "{items}\n<div class='p-3 border-top'>{pager}</div>",
                'options' => ['class' => 'msg-list'],
                'itemOptions' => ['tag' => false],
                'emptyText' => '<div class="text-center py-5 text-muted">Nenhuma mensagem enviada.</div>',

                // HTML DE CADA MENSAGEM ENVIADA
                'itemView' => function ($model) {
                    $url = Url::to(['view', 'id' => $model->id]);

                    // Tenta obter o nome do destinatário (para quem enviei)
                    $nome = $model->destinatario ? $model->destinatario->username : 'Utilizador #' . $model->destinatario_id;
                    $inicial = strtoupper(substr($nome, 0, 1));
                    $data = Yii::$app->formatter->asDate($model->data_envio, 'php:d/m/Y H:i');

                    return "
                    <a href='{$url}' class='msg-item'>
                        <div class='msg-avatar' style='background: #f1f5f9; color: #64748b;'>{$inicial}</div>
                        <div class='msg-info'>
                            <div class='msg-top'>
                                <span class='msg-name'>Para: {$nome}</span>
                                <span class='msg-date'>{$data}</span>
                            </div>
                            <div class='msg-subject'>" . Html::encode($model->assunto) . "</div>
                        </div>
                    </a>";
                },
            ]) ?>
        </div>
    </div>
</div>
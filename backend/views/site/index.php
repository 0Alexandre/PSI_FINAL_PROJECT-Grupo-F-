<?php
$this->title = 'Dashboard DomusGestLink';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">

    <!-- SECÇÃO 1: ESTATÍSTICAS DOS CONDOMÍNIOS (Visível para ambos, mas filtrado) -->
    <div class="row">
        <div class="col-lg-6 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?= $totalCondominios ?></h3>
                    <p>Condomínios Geridos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= $totalFracoes ?></h3>
                    <p>Frações / Casas Totais</p>
                </div>
                <div class="icon">
                    <i class="fas fa-door-open"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- SECÇÃO 2: ESTATÍSTICAS DE SISTEMA (Só para o Sysadmin) -->
    <?php if ($isSysAdmin): ?>
        <h4 class="mt-4 mb-3 text-muted"><i class="fas fa-cogs"></i> Dados do Sistema (Apenas Sysadmin)</h4>
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $totalUsers ?></h3>
                        <p>Total de Utilizadores</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $admins ?></h3>
                        <p>Admins Registados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                </div>
            </div>

            <!-- Podes adicionar mais caixas aqui para Proprietários e Sysadmins -->
        </div>
    <?php endif; ?>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-building"></i>
                        <?= $isSysAdmin ? 'Todos os Condomínios' : 'Os Meus Condomínios' ?>
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome do Prédio</th>
                            <th>Morada</th>
                            <th style="width: 40px">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($meusCondominios as $predio): ?>
                            <tr>
                                <td><?= $predio->id ?></td>
                                <td><strong><?= \yii\helpers\Html::encode($predio->nome) ?></strong></td>
                                <td><?= \yii\helpers\Html::encode($predio->morada) ?></td>
                                <td>
                                    <a href="<?= \yii\helpers\Url::to(['/condominio/view', 'id' => $predio->id]) ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($meusCondominios)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Ainda não existem condomínios atribuídos.
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
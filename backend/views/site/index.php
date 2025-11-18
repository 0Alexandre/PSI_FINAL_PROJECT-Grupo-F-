<?php
$this->title = 'Dashboard';
?>

<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
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
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?= $admins ?></h3>
                <p>Administradores de Condomínio</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-shield"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?= $proprietarios ?></h3>
                <p>Proprietários</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?= $sysadmins ?></h3>
                <p>Sys Admins</p>
            </div>
            <div class="icon">
                <i class="fas fa-crown"></i>
            </div>
        </div>
    </div>

</div>

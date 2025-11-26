<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

/**
 * Controlador para inicializar a estrutura de RBAC (Roles e Permissões).
 * Execução: php yii rbac/init
 */
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $loginBackend = $auth->createPermission('loginToBackend');
        $loginBackend->description = 'Fazer login na área administrativa';
        $auth->add($loginBackend);

        $gerirUsers = $auth->createPermission('gerirUtilizadores');
        $gerirUsers->description = 'Criar, editar e apagar utilizadores';
        $auth->add($gerirUsers);

        $proprietario = $auth->createRole('proprietario');
        $proprietario->description = 'Morador com acesso ao site';
        $auth->add($proprietario);

        $adminCondominio = $auth->createRole('adminCondominio');
        $adminCondominio->description = 'Gestor de Condomínio';
        $auth->add($adminCondominio);

        $auth->addChild($adminCondominio, $loginBackend);

        $sysadmin = $auth->createRole('sysadmin');
        $sysadmin->description = 'Administrador de Sistema';
        $auth->add($sysadmin);

        $auth->addChild($sysadmin, $gerirUsers);

    }
}
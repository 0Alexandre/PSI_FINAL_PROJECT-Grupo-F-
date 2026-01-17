<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); // Garante uma instalação limpa

        // 1. Criar os Roles (Papéis)
        $proprietario = $auth->createRole('proprietario');
        $proprietario->description = 'Acesso apenas ao Front-office';
        $auth->add($proprietario);

        $adminCondo = $auth->createRole('adminCondominio');
        $adminCondo->description = 'Gestor Operacional do Condomínio';
        $auth->add($adminCondo);

        $sysadmin = $auth->createRole('sysadmin');
        $sysadmin->description = 'Administrador Técnico do Sistema';
        $auth->add($sysadmin);

        // 2. Definir a Hierarquia Lógica
        // O Admin de Condomínio herda as permissões do proprietário
        $auth->addChild($adminCondo, $proprietario);

        // O sysadmin NÃO herda do adminCondo.
        // Ele é independente para gerir apenas Utilizadores e Condomínios.

        echo "RBAC configurado com sucesso: Segregação de funções ativa.\n";
    }
}
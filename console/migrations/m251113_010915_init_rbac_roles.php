<?php

use yii\db\Migration;

class m251113_010915_init_rbac_roles extends Migration
{
    public function safeUp()
    {
        $auth = \Yii::$app->authManager;

        $sysadmin = $auth->createRole('sysadmin');
        $auth->add($sysadmin);

        $adminCondominio = $auth->createRole('adminCondominio');
        $auth->add($adminCondominio);

        $proprietario = $auth->createRole('proprietario');
        $auth->add($proprietario);

        $auth->addChild($adminCondominio, $proprietario);
        $auth->addChild($sysadmin, $adminCondominio);
    }

    public function safeDown()
    {
        $auth = \Yii::$app->authManager;

        $auth->remove($auth->getRole('sysadmin'));
        $auth->remove($auth->getRole('adminCondominio'));
        $auth->remove($auth->getRole('proprietario'));
    }
}

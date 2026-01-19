<?php

namespace backend\modules\api\controllers;

use yii\rest\Controller;
use yii\filters\auth\QueryParamAuth;
use common\models\Mensagem;
use common\models\User;
use Yii;

class MensagemController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    /**
     * Retorna o histórico de mensagens enviadas pelo utilizador autenticado, 
     * ordenadas da mais recente para a mais antiga.
     */
    public function actionIndex() {
        $user = Yii::$app->user->identity;

        return Mensagem::find()
            ->where(['remetente_id' => $user->id])
            ->orWhere(['destinatario_id' => $user->id])
            ->orderBy(['data_envio' => SORT_DESC])
            ->all();
    }

    /**
     * Processa o envio de uma nova mensagem, validando se o destinatário 
     * é o SysAdmin ou o Administrador do condomínio do utilizador.
     */
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;

        $model = new Mensagem();
        $model->load(Yii::$app->request->post(), '');

        $model->remetente_id = $user->id;
        $model->data_envio = date('Y-m-d H:i:s');

        $SysAdmin = 5;

        $AdminCondominio = null;

        if (isset($user->fracao) && isset($user->fracao->condominio)) {
            $AdminCondominio = $user->fracao->condominio->admin_id;
        }

        if ($model->destinatario_id != $SysAdmin && $model->destinatario_id != $AdminCondominio) {
            $model->addError('destinatario_id', 'Erro: Só podes enviar mensagem ao Administrador ou ao SysAdmin.');
            return $model;
        }

        if ($model->save()) {
            return $model;
        }

        return $model;
    }

    /**
     * Retorna a lista de destinatários permitidos  
     * para preencher o componente de seleção  na aplicação Android.
     */
    public function actionDestinatarios()
    {
        $user = Yii::$app->user->identity;
        $lista = [];

        $lista[] = [
            'id' => 5,
            'nome' => 'Apoio Técnico (SysAdmin)'
        ];

        if (isset($user->fracao) && isset($user->fracao->condominio)) {
            $adminId = $user->fracao->condominio->admin_id;

            if ($adminId && $adminId != 5) {
                $adminUser = User::findOne($adminId);

                if ($adminUser) {
                    $lista[] = [
                        'id' => $adminUser->id,
                        'nome' => $adminUser->username
                    ];
                }
            }
        }

        return $lista;
    }
}
<?php

namespace backend\modules\api\controllers;

use common\models\Reserva;
use common\models\EspacoComum;
use common\models\Condominio;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ReservaController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::class,
        ];
        return $behaviors;
    }

    /**
     * INDEX (Read):
     * - Proprietário: Vê apenas as suas reservas.
     * - AdminCondominio: Vê todas as reservas dos espaços do seu condomínio.
     * - SysAdmin: Sem acesso.
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if (Yii::$app->user->can('sysadmin')) {
            throw new ForbiddenHttpException("O SysAdmin não tem acesso às reservas.");
        }

        // Se for Admin de Condomínio
        if ($condo = Condominio::findOne(['admin_id' => $user->id])) {
            return Reserva::find()
                ->joinWith('espaco') // Assumindo relação 'espaco' no model Reserva
                ->where(['espacos_comuns.condominio_id' => $condo->id])
                ->all();
        }

        // Se for Proprietário
        return Reserva::find()
            ->where(['utilizador_id' => $user->id])
            ->all();
    }

    /**
     * VIEW (Read): Ver detalhes de uma reserva específica.
     */
    public function actionView($id)
    {
        $user = Yii::$app->user->identity;
        $model = Reserva::findOne($id);

        if (!$model) throw new NotFoundHttpException("Reserva não encontrada.");

        $isDono = ($model->utilizador_id == $user->id);
        $isGestor = Condominio::find()
            ->joinWith('espacosComuns')
            ->where(['admin_id' => $user->id, 'espacos_comuns.id' => $model->espaco_id])
            ->exists();

        if ($isDono || $isGestor) {
            return $model;
        }

        throw new ForbiddenHttpException("Não tens permissão para ver esta reserva.");
    }

    /**
     * CREATE: Apenas o Proprietário pode criar reservas.
     */
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;

        // Se for admin de condomínio ou sysadmin, não cria reserva (regra de negócio)
        if (Yii::$app->user->can('admincondominio') || Yii::$app->user->can('sysadmin')) {
            throw new ForbiddenHttpException("Apenas proprietários podem criar reservas.");
        }

        $model = new Reserva();
        $model->load(Yii::$app->request->post(), '');
        $model->utilizador_id = $user->id;

        if ($model->save()) {
            return $model;
        }
        return $model;
    }

    /**
     * UPDATE: Apenas o AdminCondominio pode editar (ex: validar/alterar estado).
     */
    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;
        $model = Reserva::findOne($id);

        if (!$model) throw new NotFoundHttpException();

        $isGestor = Condominio::find()
            ->joinWith('espacosComuns')
            ->where(['admin_id' => $user->id, 'espacos_comuns.id' => $model->espaco_id])
            ->exists();

        if ($isGestor) {
            $model->load(Yii::$app->request->getBodyParams(), '');
            if ($model->save()) return $model;
        }

        throw new ForbiddenHttpException("Apenas o Administrador do Condomínio pode editar reservas.");
    }

    /**
     * DELETE: Proprietário (a sua) ou AdminCondominio (qualquer uma do seu prédio).
     */
    public function actionDelete($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $user = \Yii::$app->user->identity;
        if (!$user) {
            return ["error" => "Utilizador não autenticado. Verifica o token."];
        }

        $model = Reserva::findOne($id);
        if (!$model) {
            return ["error" => "Reserva não encontrada."];
        }

        $isDono = ($model->utilizador_id == $user->id);

        $isGestor = false;
        if (!$isDono) {
            $isGestor = Condominio::find()
                ->innerJoin('espacos_comuns', 'espacos_comuns.condominio_id = condominio.id')
                ->where([
                    'condominio.admin_id' => $user->id,
                    'espacos_comuns.id' => $model->espaco_id
                ])->exists();
        }

        if ($isDono || $isGestor) {
            if ($model->delete()) {
                return ["message" => "Reserva removida com sucesso."];
            }
            return ["error" => "Erro ao remover da base de dados."];
        }

        return ["error" => "Não tens permissão para remover esta reserva."];
    }
}
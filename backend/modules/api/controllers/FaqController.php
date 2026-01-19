<?php

namespace backend\modules\api\controllers;

use common\models\Faq;
use common\models\Condominio;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class FaqController extends Controller
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
     * MASTER (Lista) - Requisito 1.2
     * Retorna apenas os campos necessários para a lista no Android.
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        if (Yii::$app->user->can('sysadmin')) {
            return Faq::find()->select(['id', 'condominio_id', 'pergunta', 'resposta'])->all();
        }

        $meusCondominios = Condominio::find()
            ->select('id')
            ->where(['admin_id' => $user->id])
            ->column();

        if (isset($user->fracao->condominio_id)) {
            $meusCondominios[] = $user->fracao->condominio_id;
        }

        return Faq::find()
            ->select(['id', 'condominio_id', 'pergunta', 'resposta'])
            ->where(['or',
                ['condominio_id' => $meusCondominios],
                ['condominio_id' => null]
            ])
            ->all();
    }

    /**
     * DETAIL (Detalhe) - Requisito 1.2
     * Retorna o objeto completo incluindo a 'resposta'.
     */
    public function actionView($id)
    {
        $user = Yii::$app->user->identity;
        $model = Faq::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException("FAQ não encontrada.");
        }

        // Verificação de permissão: SysAdmin OR Gestor do prédio OR Morador do prédio
        $isGestor = Condominio::findOne(['id' => $model->condominio_id, 'admin_id' => $user->id]);
        $isMorador = (isset($user->fracao) && $user->fracao->condominio_id == $model->condominio_id);

        if (Yii::$app->user->can('sysadmin') || $isGestor || $isMorador) {
            return $model; // Retorna Pergunta + Resposta (Detail)
        }

        throw new ForbiddenHttpException("Não tens permissão para ver este detalhe.");
    }

    /**
     * CREATE - Requisito 1.1 (CRUD)
     */
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        $model = new Faq();
        $model->load(Yii::$app->request->post(), '');

        // Se for Gestor e não enviar ID do condomínio, assume o que ele gere
        if (!Yii::$app->user->can('sysadmin') && empty($model->condominio_id)) {
            $condo = Condominio::findOne(['admin_id' => $user->id]);
            if ($condo) $model->condominio_id = $condo->id;
        }

        // Validação de escrita: Apenas SysAdmin ou o Gestor daquele prédio
        $podeGravar = Yii::$app->user->can('sysadmin') ||
            Condominio::findOne(['id' => $model->condominio_id, 'admin_id' => $user->id]);

        if ($podeGravar && $model->save()) {
            return $model;
        }

        throw new ForbiddenHttpException("Não tens permissão para criar FAQs.");
    }

    /**
     * UPDATE - Requisito 1.1 (CRUD)
     */
    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;
        $model = Faq::findOne($id);

        if (!$model) throw new NotFoundHttpException("Registo inexistente.");

        $podeEditar = Yii::$app->user->can('sysadmin') ||
            Condominio::findOne(['id' => $model->condominio_id, 'admin_id' => $user->id]);

        if ($podeEditar) {
            $model->load(Yii::$app->request->getBodyParams(), '');
            if ($model->save()) return $model;
        }

        throw new ForbiddenHttpException("Acesso negado.");
    }

    /**
     * DELETE - Requisito 1.1 (CRUD)
     */
    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;
        $model = Faq::findOne($id);

        if (!$model) throw new NotFoundHttpException("Registo inexistente.");

        $podeApagar = Yii::$app->user->can('sysadmin') ||
            Condominio::findOne(['id' => $model->condominio_id, 'admin_id' => $user->id]);

        if ($podeApagar) {
            $model->delete();
            return ['message' => 'FAQ eliminada com sucesso.'];
        }

        throw new ForbiddenHttpException("Acesso negado.");
    }
}

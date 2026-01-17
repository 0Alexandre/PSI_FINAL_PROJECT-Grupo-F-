<?php

namespace backend\modules\api\controllers;

use common\models\Anuncio;
use common\models\Condominio;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class AnuncioController extends Controller
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
     * MASTER (Lista para Android)
     * Objetivo: Lista leve de anúncios para o RecyclerView.
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $query = Anuncio::find()->select(['id', 'titulo', 'conteudo', 'tipo', 'data', 'condominio_id', 'visivel_publico'])->orderBy(['data' => SORT_DESC]);

        if (Yii::$app->user->can('sysadmin')) {
            return $query->all();
        }

        $meusCondominios = Condominio::find()
            ->select('id')
            ->where(['admin_id' => $user->id])
            ->column();

        if (isset($user->fracao->condominio_id)) {
            $meusCondominios[] = $user->fracao->condominio_id;
        }

        return $query->where(['condominio_id' => $meusCondominios])->all();
    }

    /**
     * DETAIL (Detalhe para Android) - 
     * Objetivo: Retorna o anúncio completo (incluindo o 'conteudo').
     */
    public function actionView($id)
    {
        $user = Yii::$app->user->identity;
        $model = Anuncio::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException("Anúncio não encontrado.");
        }

        $isGestor = Condominio::findOne(['id' => $model->condominio_id, 'admin_id' => $user->id]);
        $isMorador = (isset($user->fracao) && $user->fracao->condominio_id == $model->condominio_id);

        if (Yii::$app->user->can('sysadmin') || $isGestor || $isMorador) {
            return $model; 
        }

        throw new ForbiddenHttpException("Não tens permissão para ver este anúncio.");
    }

    /**
     * CREATE (Apenas Gestão / Postman)
     */
    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        $model = new Anuncio();
        $model->load(Yii::$app->request->post(), '');
        $model->data = date('Y-m-d H:i:s'); 

        if (!Yii::$app->user->can('sysadmin') && empty($model->condominio_id)) {
            $condo = Condominio::findOne(['admin_id' => $user->id]);
            if ($condo) $model->condominio_id = $condo->id;
        }

        $podeGravar = Yii::$app->user->can('sysadmin') ||
            Condominio::findOne(['id' => $model->condominio_id, 'admin_id' => $user->id]);

        if ($podeGravar && $model->save()) {
            return $model;
        }

        throw new ForbiddenHttpException("Sem permissão para criar anúncios neste condomínio.");
    }

    /**
     * UPDATE (Apenas Gestão / Postman)
     */
    public function actionUpdate($id)
    {
        $user = Yii::$app->user->identity;
        $model = Anuncio::findOne($id);

        if (!$model) throw new NotFoundHttpException("Anúncio inexistente.");

        $podeEditar = Yii::$app->user->can('sysadmin') ||
            Condominio::findOne(['id' => $model->condominio_id, 'admin_id' => $user->id]);

        if ($podeEditar) {
            $model->load(Yii::$app->request->getBodyParams(), '');
            if ($model->save()) return $model;
        }

        throw new ForbiddenHttpException("Não tens permissão para editar este anúncio.");
    }

    /**
     * DELETE (Apenas Gestão / Postman)
     */
    public function actionDelete($id)
    {
        $user = Yii::$app->user->identity;
        $model = Anuncio::findOne($id);

        if (!$model) throw new NotFoundHttpException("Anúncio inexistente.");

        $podeApagar = Yii::$app->user->can('sysadmin') ||
            Condominio::findOne(['id' => $model->condominio_id, 'admin_id' => $user->id]);

        if ($podeApagar) {
            $model->delete();
            return ['message' => 'Anúncio eliminado com sucesso.'];
        }

        throw new ForbiddenHttpException("Não tens permissão para eliminar este anúncio.");
    }
}
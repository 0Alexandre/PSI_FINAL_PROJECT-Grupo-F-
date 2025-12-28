<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property int $id
 * @property int $condominio_id
 * @property string $pergunta
 * @property string $resposta
 * @property int|null $visivel_publico
 *
 * @property Condominios $condominio
 */
class Faq extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visivel_publico'], 'default', 'value' => 1],
            [['pergunta', 'resposta'], 'required'],
            [['condominio_id', 'visivel_publico'], 'integer'],
            [['pergunta', 'resposta'], 'string'],
            [['condominio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Condominio::class, 'targetAttribute' => ['condominio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'condominio_id' => 'Condominio ID',
            'pergunta' => 'Pergunta',
            'resposta' => 'Resposta',
            'visivel_publico' => 'Visivel Publico',
        ];
    }

    /**
     * Gets query for [[Condominio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCondominio()
    {
        return $this->hasOne(Condominio::class, ['id' => 'condominio_id']);
    }

}

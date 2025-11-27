<?php

namespace common\models;
use common\models\Condominio;

use Yii;

/**
 * This is the model class for table "fracoes".
 *
 * @property int $id
 * @property int $condominio_id
 * @property int $proprietario_id
 * @property string $codigo
 *
 * @property Condominio $condominio
 * @property User $proprietario
 */
class Fracao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fracoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['condominio_id', 'proprietario_id', 'codigo'], 'required'],
            [['condominio_id', 'proprietario_id'], 'integer'],
            [['codigo'], 'string', 'max' => 50],
            [['condominio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Condominio::class, 'targetAttribute' => ['condominio_id' => 'id']],
            [['proprietario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['proprietario_id' => 'id']],
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
            'proprietario_id' => 'Proprietario ID',
            'codigo' => 'Codigo',
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

    /**
     * Gets query for [[Proprietario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProprietario()
    {
        return $this->hasOne(User::class, ['id' => 'proprietario_id']);
    }

}

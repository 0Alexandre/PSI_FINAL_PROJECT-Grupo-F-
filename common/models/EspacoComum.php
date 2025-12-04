<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "espacos_comuns".
 *
 * @property int $id
 * @property int $condominio_id
 * @property string $nome
 * @property string|null $descricao
 *
 * @property Condominios $condominio
 * @property Reservas[] $reservas
 */
class EspacoComum extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'espacos_comuns';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao'], 'default', 'value' => null],
            [['condominio_id', 'nome'], 'required'],
            [['condominio_id'], 'integer'],
            [['descricao'], 'string'],
            [['nome'], 'string', 'max' => 100],
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
            'nome' => 'Nome',
            'descricao' => 'Descricao',
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
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reservas::class, ['espaco_id' => 'id']);
    }

}

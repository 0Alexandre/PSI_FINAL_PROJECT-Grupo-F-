<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mensagens".
 *
 * @property int $id
 * @property int $remetente_id
 * @property int $destinatario_id
 * @property string|null $assunto
 * @property string $corpo
 * @property string|null $data_envio
 *
 * @property User $destinatario
 * @property User $remetente
 */
class Mensagem extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensagens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assunto'], 'default', 'value' => null],
            [['remetente_id', 'destinatario_id', 'corpo'], 'required'],
            [['remetente_id', 'destinatario_id'], 'integer'],
            [['corpo'], 'string'],
            [['data_envio'], 'safe'],
            [['assunto'], 'string', 'max' => 150],
            [['remetente_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['remetente_id' => 'id']],
            [['destinatario_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['destinatario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'remetente_id' => 'Remetente ID',
            'destinatario_id' => 'Destinatario ID',
            'assunto' => 'Assunto',
            'corpo' => 'Corpo',
            'data_envio' => 'Data Envio',
        ];
    }

    /**
     * Gets query for [[Destinatario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDestinatario()
    {
        return $this->hasOne(User::class, ['id' => 'destinatario_id']);
    }

    /**
     * Gets query for [[Remetente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRemetente()
    {
        return $this->hasOne(User::class, ['id' => 'remetente_id']);
    }

}

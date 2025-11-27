<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "perfil".
 *
 * @property int $id
 * @property int $user_id
 * @property string $perfil
 * @property string|null $telefone
 * @property string|null $foto_perfil
 * @property string|null $morada
 * @property string|null $data_nascimento
 */
class Perfil extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perfil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telefone', 'foto_perfil', 'morada', 'data_nascimento'], 'default', 'value' => null],
            [['user_id', 'perfil'], 'required'],
            [['user_id'], 'integer'],
            [['data_nascimento'], 'safe'],
            [['perfil', 'foto_perfil', 'morada'], 'string', 'max' => 255],
            [['telefone'], 'string', 'max' => 20],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'perfil' => 'Perfil',
            'telefone' => 'Telefone',
            'foto_perfil' => 'Foto Perfil',
            'morada' => 'Morada',
            'data_nascimento' => 'Data Nascimento',
        ];
    }

}

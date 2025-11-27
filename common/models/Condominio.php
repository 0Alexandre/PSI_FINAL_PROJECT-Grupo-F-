<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "condominios".
 *
 * @property int $id
 * @property string $nome
 * @property string $morada
 * @property int $admin_id
 *
 * @property User $admin
 * @property Anuncios[] $anuncios
 * @property EspacosComuns[] $espacosComuns
 * @property Faq[] $faqs
 * @property Fracoes[] $fracoes
 */
class Condominio extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'condominios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'morada', 'admin_id'], 'required'],
            [['admin_id'], 'integer'],
            [['nome'], 'string', 'max' => 120],
            [['morada'], 'string', 'max' => 200],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['admin_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'morada' => 'Morada',
            'admin_id' => 'Admin ID',
        ];
    }

    /**
     * Gets query for [[Admin]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(User::class, ['id' => 'admin_id']);
    }

    /**
     * Gets query for [[Anuncios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnuncios()
    {
        return $this->hasMany(Anuncios::class, ['condominio_id' => 'id']);
    }

    /**
     * Gets query for [[EspacosComuns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEspacosComuns()
    {
        return $this->hasMany(EspacosComuns::class, ['condominio_id' => 'id']);
    }

    /**
     * Gets query for [[Faqs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaqs()
    {
        return $this->hasMany(Faq::class, ['condominio_id' => 'id']);
    }

    /**
     * Gets query for [[Fracoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFracoes()
    {
        return $this->hasMany(Fracoes::class, ['condominio_id' => 'id']);
    }

}

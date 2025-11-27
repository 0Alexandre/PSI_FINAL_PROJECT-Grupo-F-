<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reservas".
 *
 * @property int $id
 * @property int $espaco_id
 * @property int $utilizador_id
 * @property string $inicio
 * @property string $fim
 * @property string|null $estado
 *
 * @property EspacosComuns $espaco
 * @property User $utilizador
 */
class Reserva extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const ESTADO_PENDENTE = 'PENDENTE';
    const ESTADO_APROVADA = 'APROVADA';
    const ESTADO_REJEITADA = 'REJEITADA';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => 'PENDENTE'],
            [['espaco_id', 'utilizador_id', 'inicio', 'fim'], 'required'],
            [['espaco_id', 'utilizador_id'], 'integer'],
            [['inicio', 'fim'], 'safe'],
            [['estado'], 'string'],
            ['estado', 'in', 'range' => array_keys(self::optsEstado())],
            [['espaco_id'], 'exist', 'skipOnError' => true, 'targetClass' => EspacosComuns::class, 'targetAttribute' => ['espaco_id' => 'id']],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'espaco_id' => 'Espaco ID',
            'utilizador_id' => 'Utilizador ID',
            'inicio' => 'Inicio',
            'fim' => 'Fim',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Espaco]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEspaco()
    {
        return $this->hasOne(EspacosComuns::class, ['id' => 'espaco_id']);
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(User::class, ['id' => 'utilizador_id']);
    }


    /**
     * column estado ENUM value labels
     * @return string[]
     */
    public static function optsEstado()
    {
        return [
            self::ESTADO_PENDENTE => 'PENDENTE',
            self::ESTADO_APROVADA => 'APROVADA',
            self::ESTADO_REJEITADA => 'REJEITADA',
        ];
    }

    /**
     * @return string
     */
    public function displayEstado()
    {
        return self::optsEstado()[$this->estado];
    }

    /**
     * @return bool
     */
    public function isEstadoPendente()
    {
        return $this->estado === self::ESTADO_PENDENTE;
    }

    public function setEstadoToPendente()
    {
        $this->estado = self::ESTADO_PENDENTE;
    }

    /**
     * @return bool
     */
    public function isEstadoAprovada()
    {
        return $this->estado === self::ESTADO_APROVADA;
    }

    public function setEstadoToAprovada()
    {
        $this->estado = self::ESTADO_APROVADA;
    }

    /**
     * @return bool
     */
    public function isEstadoRejeitada()
    {
        return $this->estado === self::ESTADO_REJEITADA;
    }

    public function setEstadoToRejeitada()
    {
        $this->estado = self::ESTADO_REJEITADA;
    }
}

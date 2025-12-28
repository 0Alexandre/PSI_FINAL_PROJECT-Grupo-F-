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
            [['espaco_id', 'utilizador_id', 'inicio', 'fim'], 'required', 'message' => 'Campo obrigatório'],
            [['espaco_id', 'utilizador_id'], 'integer'],
            [['estado'], 'string'],
            [['inicio', 'fim'], 'safe'],
            ['estado', 'default', 'value' => 'Pendente'],

            ['fim', 'compare', 'compareAttribute' => 'inicio', 'operator' => '>', 'message' => 'A data de fim deve ser depois do início.'],

            ['inicio', 'validarSobreposicao'],

            [['espaco_id'], 'exist', 'skipOnError' => true, 'targetClass' => EspacoComum::class, 'targetAttribute' => ['espaco_id' => 'id']],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * Valida se já existe uma reserva no mesmo horário para o mesmo espaço.
     */
    public function validarSobreposicao($attribute, $params)
    {
        if ($this->hasErrors()) {
            return;
        }

        // Procura conflitos na base de dados
        $query = self::find()
            ->where(['espaco_id' => $this->espaco_id])
            ->andWhere(['<', 'inicio', $this->fim])
            ->andWhere(['>', 'fim', $this->inicio]);

        if (!$this->isNewRecord) {
            $query->andWhere(['!=', 'id', $this->id]);
        }

        // Se encontrar algum registo, bloqueia
        if ($query->exists()) {
            $this->addError($attribute, 'Este horário já está ocupado por outra reserva.');
            $this->addError('fim', 'Conflito de horário.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'espaco_id' => 'Espaço',
            'utilizador_id' => 'Utilizador',
            'inicio' => 'Início da Reserva',
            'fim' => 'Fim da Reserva',
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
        return $this->hasOne(EspacoComum::class, ['id' => 'espaco_id']);
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
        $estados = self::optsEstado();
        return isset($estados[$this->estado]) ? $estados[$this->estado] : $this->estado;
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
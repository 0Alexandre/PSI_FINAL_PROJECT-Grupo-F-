<?php

namespace common\models;

use Yii;
use common\mosquitto\phpMQTT;
/**
 * This is the model class for table "anuncios".
 *
 * @property int $id
 * @property int $condominio_id
 * @property string $titulo
 * @property string|null $conteudo
 * @property string|null $tipo
 * @property string|null $data
 * @property int|null $visivel_publico
 *
 * @property Condominios $condominio
 */
class Anuncio extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const TIPO_GERAL = 'GERAL';
    const TIPO_REUNIAO = 'REUNIAO';
    const TIPO_MANUTENCAO = 'MANUTENCAO';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anuncios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conteudo'], 'default', 'value' => null],
            [['tipo'], 'default', 'value' => 'GERAL'],
            [['visivel_publico'], 'default', 'value' => 1],
            [['condominio_id', 'titulo'], 'required'],
            [['condominio_id', 'visivel_publico'], 'integer'],
            [['conteudo', 'tipo'], 'string'],
            [['data'], 'safe'],
            [['titulo'], 'string', 'max' => 150],
            ['tipo', 'in', 'range' => array_keys(self::optsTipo())],
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
            'titulo' => 'Titulo',
            'conteudo' => 'Conteudo',
            'tipo' => 'Tipo',
            'data' => 'Data',
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


    /**
     * column tipo ENUM value labels
     * @return string[]
     */
    public static function optsTipo()
    {
        return [
            self::TIPO_GERAL => 'GERAL',
            self::TIPO_REUNIAO => 'REUNIAO',
            self::TIPO_MANUTENCAO => 'MANUTENCAO',
        ];
    }

    /**
     * @return string
     */
    public function displayTipo()
    {
        return self::optsTipo()[$this->tipo];
    }

    /**
     * @return bool
     */
    public function isTipoGeral()
    {
        return $this->tipo === self::TIPO_GERAL;
    }

    public function setTipoToGeral()
    {
        $this->tipo = self::TIPO_GERAL;
    }

    /**
     * @return bool
     */
    public function isTipoReuniao()
    {
        return $this->tipo === self::TIPO_REUNIAO;
    }

    public function setTipoToReuniao()
    {
        $this->tipo = self::TIPO_REUNIAO;
    }

    /**
     * @return bool
     */
    public function isTipoManutencao()
    {
        return $this->tipo === self::TIPO_MANUTENCAO;
    }

    public function setTipoToManutencao()
    {
        $this->tipo = self::TIPO_MANUTENCAO;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $myObj = new \stdClass();
        $myObj->id = $this->id;
        $myObj->titulo = $this->titulo;
        $myObj->conteudo = $this->conteudo;
        $myObj->data = $this->data;
        $myObj->tipo_model = 'ANUNCIO';
        $myJSON = json_encode($myObj);

        if ($insert) {
            $this->FazPublishNoMosquitto("INSERT", $myJSON);
        } else {
            $this->FazPublishNoMosquitto("UPDATE", $myJSON);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $myJSON = json_encode(['id' => $this->id]);
        $this->FazPublishNoMosquitto("DELETE", $myJSON);
    }

    public function FazPublishNoMosquitto($canal, $msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $client_id = "phpMQTT-publisher-anuncio";

        $mqtt = new phpMQTT($server, $port, $client_id);

        if ($mqtt->connect(true, NULL, "", "")) {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        }
    }
}

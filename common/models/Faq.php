<?php

namespace common\models;

use Yii;
use common\mosquitto\phpMQTT;

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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $myObj = new \stdClass();
        $myObj->id = $this->id;
        $myObj->condominio_id = $this->condominio_id;
        $myObj->pergunta = $this->pergunta;
        $myObj->resposta = $this->resposta;
        $myObj->tipo_model = 'FAQ';

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

        $myObj = new \stdClass();
        $myObj->id = $this->id;
        $myObj->tipo_model = 'FAQ';
        $myJSON = json_encode($myObj);

        $this->FazPublishNoMosquitto("DELETE", $myJSON);
    }

    public function FazPublishNoMosquitto($canal, $msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $client_id = "phpMQTT-publisher-faq";

        $mqtt = new phpMQTT($server, $port, $client_id);

        if ($mqtt->connect(true, NULL, "", "")) {
            $mqtt->publish($canal, $msg, 0);
            $mqtt->close();
        }
    }
}

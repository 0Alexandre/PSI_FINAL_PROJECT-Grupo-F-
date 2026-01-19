<?php

namespace common\models;

use Yii;
use common\mosquitto\phpMQTT;
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

    public function fields()
    {
        $fields = parent::fields();

        // Adiciona o nome do remetente ao JSON para o Android ler
        $fields['remetente_nome'] = function ($model) {
            // Usamos 'username' para aparecer 'admin1' ou 'sysadmin'
            return $model->remetente ? $model->remetente->username : 'Desconhecido';
        };

        return $fields;
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

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $myObj = new \stdClass();
            $myObj->id = $this->id;
            $myObj->assunto = $this->assunto;
            $myObj->corpo = $this->corpo; // O conteúdo da mensagem
            $myObj->tipo_model = 'MENSAGEM';

            $myJSON = json_encode($myObj);

            // MUDA AQUI: Usar o tópico que o Android vai ouvir
            $this->FazPublishNoMosquitto("condominio/mensagens", $myJSON);
        }
    }

    public function FazPublishNoMosquitto($topico, $msg)
    {
        $server = "127.0.0.1";
        $port = 1883;
        $client_id = "phpMQTT-publisher-mensagem";

        $mqtt = new phpMQTT($server, $port, $client_id);

        if ($mqtt->connect(true, NULL, "", "")) {
            $mqtt->publish($topico, $msg, 0);
            $mqtt->close();
        }
    }
}

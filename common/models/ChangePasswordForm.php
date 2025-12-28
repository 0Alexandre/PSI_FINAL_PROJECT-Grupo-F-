<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $repeatPassword;

    // 1. AQUI TRADUZES AS MENSAGENS DE ERRO
    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'repeatPassword'], 'required', 'message' => 'Este campo não pode ficar vazio.'],
            [['newPassword'], 'string', 'min' => 6, 'tooShort' => 'A password deve ter pelo menos 6 caracteres.'],
            ['repeatPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'As passwords não coincidem.'],
            ['currentPassword', 'validateCurrentPassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'currentPassword' => 'Password Atual',
            'newPassword' => 'Nova Password',
            'repeatPassword' => 'Repetir Password',
        ];
    }

    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;
            if (!$user || !$user->validatePassword($this->currentPassword)) {
                $this->addError($attribute, 'A password atual está incorreta.');
            }
        }
    }

    public function changePassword()
    {
        if ($this->validate()) {
            $user = User::findOne(Yii::$app->user->id);
            $user->setPassword($this->newPassword);
            $user->generateAuthKey();
            return $user->save();
        }
        return false;
    }
}
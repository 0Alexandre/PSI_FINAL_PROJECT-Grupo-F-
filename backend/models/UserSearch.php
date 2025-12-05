<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends User
{
    public $perfil_nome;
    public $telefone;
    public $morada;
    public $data_nascimento;
    public $foto_perfil;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'safe'],

            [['perfil_nome', 'telefone', 'morada', 'data_nascimento',], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     */
    public function search($params, $formName = null)
    {
        $query = User::find();

        $query->joinWith('perfil');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['telefone'] = [
            'asc' => ['perfil.telefone' => SORT_ASC],
            'desc' => ['perfil.telefone' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['morada'] = [
            'asc' => ['perfil.morada' => SORT_ASC],
            'desc' => ['perfil.morada' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['perfil_nome'] = [
            'asc' => ['perfil.perfil' => SORT_ASC],
            'desc' => ['perfil.perfil' => SORT_DESC],
        ];

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'user.id' => $this->id,
            'user.status' => $this->status,
            'user.created_at' => $this->created_at,
            'user.updated_at' => $this->updated_at,
            'perfil.data_nascimento' => $this->data_nascimento,
        ]);

        $query->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'user.auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'user.password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'user.password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'user.verification_token', $this->verification_token])

            ->andFilterWhere(['like', 'perfil.perfil', $this->perfil_nome])
            ->andFilterWhere(['like', 'perfil.morada', $this->morada]);

        return $dataProvider;
    }
}
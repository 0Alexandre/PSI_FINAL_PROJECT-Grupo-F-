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
    // NOVAS VARIÁVEIS PARA PESQUISA (Não pertencem a User, mas a Perfil)
    public $perfil_data;
    public $telefone;
    public $morada;
    public $data_nascimento;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Removidas as colunas antigas da tabela User que já não existem
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'verification_token',

                // NOVAS VARIÁVEIS DE PESQUISA (Têm de estar nas rules)
                'perfil_data', 'telefone', 'morada', 'data_nascimento'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        // AQUI ESTÁ O SEGREDO: Fazer o JOIN com a tabela 'perfil'
        $query = User::find()->joinWith(['perfil']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'data_nascimento' => $this->data_nascimento, // Não pode ser aqui, tem que ser na tabela 'perfil'

            // FILTROS ESPECÍFICOS:
            'perfil.data_nascimento' => $this->data_nascimento, // Pesquisar na tabela perfil
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])

            // NOVO: Filtros para a Tabela 'perfil'
            ->andFilterWhere(['like', 'perfil.perfil', $this->perfil_data]) // Assumi que o perfil tem agora o nome perfil_data
            ->andFilterWhere(['like', 'perfil.telefone', $this->telefone])
            ->andFilterWhere(['like', 'perfil.morada', $this->morada]);

        return $dataProvider;
    }
}
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
    // 1. CRIAR AS VARIÁVEIS PÚBLICAS
    // Como estes campos saíram da tabela 'user', temos de os declarar aqui
    // para o formulário de pesquisa ter onde guardar o que escreves.
    public $perfil_nome; // Campo para pesquisar o tipo de perfil (admin/user)
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

            // 2. TORNAR AS VARIÁVEIS SEGURAS PARA PESQUISA
            [['perfil_nome', 'telefone', 'morada', 'data_nascimento', 'foto_perfil'], 'safe'],
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

        // 3. FAZER O JOIN COM A TABELA PERFIL
        // Isto é fundamental! Junta a tabela 'user' com a tabela 'perfil' na pesquisa
        $query->joinWith('perfil');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // (Opcional) Configurar a ordenação para funcionar ao clicar nos títulos das colunas
        $dataProvider->sort->attributes['telefone'] = [
            'asc' => ['perfil.telefone' => SORT_ASC],
            'desc' => ['perfil.telefone' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['morada'] = [
            'asc' => ['perfil.morada' => SORT_ASC],
            'desc' => ['perfil.morada' => SORT_DESC],
        ];
        // Nota: assumindo que a coluna na tabela perfil se chama 'perfil' também
        $dataProvider->sort->attributes['perfil_nome'] = [
            'asc' => ['perfil.perfil' => SORT_ASC],
            'desc' => ['perfil.perfil' => SORT_DESC],
        ];

        $this->load($params, $formName);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // 4. FILTRAR
        // Aqui dizemos explicitamente para procurar na tabela 'user' ou na tabela 'perfil'

        $query->andFilterWhere([
            'user.id' => $this->id, // user.id para não confundir com perfil.id
            'user.status' => $this->status,
            'user.created_at' => $this->created_at,
            'user.updated_at' => $this->updated_at,
            'perfil.data_nascimento' => $this->data_nascimento, // Procura na tabela Perfil
        ]);

        $query->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'user.auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'user.password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'user.password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'user.verification_token', $this->verification_token])

            // Filtros da tabela PERFIL
            ->andFilterWhere(['like', 'perfil.perfil', $this->perfil_nome]) // Atenção: mapeia $this->perfil_nome para a coluna perfil.perfil
            ->andFilterWhere(['like', 'perfil.telefone', $this->telefone])
            ->andFilterWhere(['like', 'perfil.foto_perfil', $this->foto_perfil])
            ->andFilterWhere(['like', 'perfil.morada', $this->morada]);

        return $dataProvider;
    }
}
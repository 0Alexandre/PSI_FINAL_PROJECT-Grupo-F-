<?php

use yii\db\Migration;
use yii\db\Query; // Importar Query para garantir que a classe é encontrada

/**
 * Cria a tabela perfil e transfere os dados existentes da tabela user.
 */
class m251126_145527_create_perfil_table_with_data_transfer extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 1. CRIAR A TABELA 'PERFIL'
        $this->createTable('{{%perfil}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(), // Ligação 1:1 ao utilizador
            'perfil' => $this->string()->notNull(),
            'telefone' => $this->string(20),
            'foto_perfil' => $this->string(),
            'morada' => $this->string(),
            'data_nascimento' => $this->date(),
        ]);

        // 2. ADICIONAR A CHAVE ESTRANGEIRA
        $this->addForeignKey(
            'fk-perfil-user_id',
            '{{%perfil}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE' // Se o utilizador for apagado, o perfil também é
        );

        // ====================================================================
        // 3. TRANSFERÊNCIA DOS DADOS (O MAIS IMPORTANTE!)
        // ====================================================================

        // Usamos uma transação para garantir que, se falhar, nada é alterado
        $transaction = $this->db->beginTransaction();
        try {
            // Ir buscar todos os utilizadores existentes
            // Usando yii\db\Query que importamos no topo
            $users = (new Query())
                ->select(['id', 'perfil', 'telefone', 'foto_perfil', 'morada', 'data_nascimento'])
                ->from('{{%user}}')
                ->all();

            foreach ($users as $user) {
                // Inserir uma nova linha na tabela perfil para cada utilizador
                $this->insert('{{%perfil}}', [
                    'user_id' => $user['id'],
                    'perfil' => $user['perfil'],
                    'telefone' => $user['telefone'],
                    'foto_perfil' => $user['foto_perfil'],
                    'morada' => $user['morada'],
                    'data_nascimento' => $user['data_nascimento'],
                ]);
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        // 4. LIMPAR A TABELA USER (Remover as colunas antigas)
        $this->dropColumn('{{%user}}', 'perfil');
        $this->dropColumn('{{%user}}', 'telefone');
        $this->dropColumn('{{%user}}', 'foto_perfil');
        $this->dropColumn('{{%user}}', 'morada');
        $this->dropColumn('{{%user}}', 'data_nascimento');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Se precisares de reverter, este bloco volta a criar as colunas
        $this->addColumn('{{%user}}', 'perfil', $this->string()->notNull());
        $this->addColumn('{{%user}}', 'telefone', $this->string(20));
        $this->addColumn('{{%user}}', 'foto_perfil', $this->string());
        $this->addColumn('{{%user}}', 'morada', $this->string());
        $this->addColumn('{{%user}}', 'data_nascimento', $this->date());

        // Apagar chaves e tabelas criadas
        $this->dropForeignKey('fk-perfil-user_id', '{{%perfil}}');
        $this->dropTable('{{%perfil}}');
    }
}
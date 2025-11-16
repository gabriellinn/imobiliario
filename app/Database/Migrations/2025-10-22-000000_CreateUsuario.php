<?php

namespace App\Database\Migrations;

// Importa a classe base Migration do CodeIgniter
// Todas as migrations devem estender esta classe
use CodeIgniter\Database\Migration;

/**
 * Migration: CreateUsuario
 * 
 * O QUE É UMA MIGRATION?
 * Migration = "Migração de banco de dados"
 * É uma forma de versionar a estrutura do banco de dados.
 * Permite criar, alterar ou excluir tabelas de forma controlada.
 * 
 * COMO FUNCIONA?
 * - up() = Aplica a migration (cria/modifica tabelas)
 * - down() = Reverte a migration (desfaz as mudanças)
 * 
 * POR QUE USAR?
 * - Permite versionar mudanças no banco
 * - Facilita deploy em diferentes ambientes
 * - Permite reverter mudanças se necessário
 * - Equipe pode sincronizar estrutura do banco facilmente
 * 
 * COMO EXECUTAR?
 * php spark migrate        = Executa todas as migrations pendentes
 * php spark migrate:rollback = Reverte a última migration
 * php spark migrate:status   = Mostra status das migrations
 */
class CreateUsuario extends Migration
{
    /**
     * Método UP - Aplica a migration (cria a tabela)
     * 
     * Este método é executado quando você roda: php spark migrate
     * 
     * @return void
     * 
     * DE ONDE VEM?
     * - $this->db = Propriedade herdada da classe Migration
     *   Representa a conexão com o banco de dados
     * - $this->forge = Propriedade herdada da classe Migration
     *   Objeto que permite criar/modificar estruturas de tabelas
     * - tableExists() = Método do Database para verificar se tabela existe
     * - addField() = Método do Forge para adicionar campos à tabela
     * - addKey() = Método do Forge para adicionar chaves (PRIMARY, UNIQUE, etc)
     * - createTable() = Método do Forge para criar a tabela no banco
     */
    public function up()
    {
        // Verifica se a tabela já existe antes de criar
        // Isso evita erro se rodar a migration duas vezes
        // tableExists() retorna true se a tabela existe, false caso contrário
        if ($this->db->tableExists('usuarios')) {
            return; // Se já existe, não faz nada (migration já foi aplicada)
        }

        // Define os campos da tabela 'usuarios'
        // addField() aceita um array associativo com configurações de cada campo
        $this->forge->addField([
            // Campo ID - Chave primária da tabela
            'id' => [
                'type'           => 'INT',          // Tipo do campo: INTEGER (número inteiro)
                'constraint'     => 11,             // Tamanho máximo: 11 dígitos
                'unsigned'       => true,           // Sem sinal (apenas números positivos)
                'auto_increment' => true            // Auto-incremento (1, 2, 3, 4...)
                // AUTO_INCREMENT = O banco gera automaticamente o próximo número
            ],
            
            // Campo NOME - Nome do usuário
            'nome' => [
                'type'       => 'VARCHAR',          // Tipo: String variável
                'constraint' => '100',              // Tamanho máximo: 100 caracteres
                'null'       => false,              // NOT NULL (campo obrigatório)
            ],

            // Campo EMAIL - Email do usuário (deve ser único)
            'email' => [
                'type'       => 'VARCHAR',          // Tipo: String variável
                'constraint' => '100',              // Tamanho máximo: 100 caracteres
                'null'       => false,              // NOT NULL (campo obrigatório)
                'unique'     => true,               // UNIQUE (não pode repetir)
                // UNIQUE garante que não haverá dois emails iguais
            ],
            
            // Campo SENHA - Senha criptografada (hash)
            'senha' => [
                'type'       => 'VARCHAR',          // Tipo: String variável
                'constraint' => '255',              // Tamanho: 255 caracteres
                                                  // (hash de senha precisa de mais espaço)
                'null'       => false,              // NOT NULL (campo obrigatório)
                // IMPORTANTE: Senhas devem ser armazenadas como hash, nunca em texto plano
                // Exemplo de hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
            ],

            // Campo TIPO - Tipo de usuário (admin ou corretor)
            'tipo' => [
                'type'       => 'ENUM',             // Tipo: Enumeração (valores pré-definidos)
                'constraint' => ['admin', 'corretor'], // Valores permitidos
                'null'       => false,              // NOT NULL (campo obrigatório)
                // ENUM = O campo só pode ter um dos valores listados
                // Exemplos válidos: 'admin', 'corretor'
                // Exemplo inválido: 'usuario' (não está na lista)
            ]
        ]);

        // Adiciona a chave primária
        // addKey('id', true) = Define o campo 'id' como PRIMARY KEY
        // O segundo parâmetro 'true' indica que é chave primária
        $this->forge->addKey('id', true);
        
        // Cria a tabela no banco de dados
        // createTable('usuarios') = Executa o SQL CREATE TABLE usuarios (...)
        // O nome da tabela será 'usuarios'
        $this->forge->createTable('usuarios');
    }

    /**
     * Método DOWN - Reverte a migration (exclui a tabela)
     * 
     * Este método é executado quando você roda: php spark migrate:rollback
     * 
     * @return void
     * 
     * DE ONDE VEM?
     * - dropTable() = Método do Forge para excluir uma tabela
     *   Equivale a: DROP TABLE IF EXISTS usuarios
     */
    public function down()
    {
        // Exclui a tabela 'usuarios' do banco de dados
        // dropTable() = Executa o SQL DROP TABLE usuarios
        // 
        // ATENÇÃO: Isso apaga TODOS os dados da tabela!
        // Use com cuidado em produção
        $this->forge->dropTable('usuarios');
    }
}

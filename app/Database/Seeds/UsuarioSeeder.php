<?php

namespace App\Database\Seeds;

// Importa a classe base Seeder do CodeIgniter
use CodeIgniter\Database\Seeder;

/**
 * UsuarioSeeder - Cria Usuários Iniciais
 * 
 * Este seeder cria usuários básicos necessários para o sistema funcionar:
 * - 1 usuário admin (para acessar o painel administrativo)
 * - 1 usuário corretor (para testar funcionalidades de corretor)
 * 
 * IMPORTANTE:
 * - As senhas são criptografadas usando password_hash() do PHP
 * - Nunca armazene senhas em texto plano!
 * - A senha padrão é '123456' (mude em produção)
 */
class UsuarioSeeder extends Seeder
{
    /**
     * Executa o seeder
     * 
     * FLUXO:
     * 1. Verifica se a tabela existe
     * 2. Verifica se já existem usuários (evita duplicatas)
     * 3. Prepara os dados dos usuários
     * 4. Insere os dados no banco
     * 
     * @return void
     * 
     * DE ONDE VEM?
     * - $this->db = Propriedade herdada da classe Seeder
     *   Representa a conexão com o banco de dados
     * - tableExists() = Método do Database para verificar se tabela existe
     * - table()->countAllResults() = Query Builder para contar registros
     * - table()->insertBatch() = Query Builder para inserir múltiplos registros
     * - password_hash() = Função nativa do PHP para criar hash de senha
     */
    public function run()
    {
        // Verifica se a tabela 'usuarios' existe
        // Se não existir, mostra mensagem e interrompe a execução
        if (!$this->db->tableExists('usuarios')) {
            echo "Tabela 'usuarios' não existe. Execute as migrations primeiro.\n";
            return; // Interrompe a execução do seeder
        }

        // Verifica se já existem usuários na tabela
        // countAllResults() retorna a quantidade de registros na tabela
        // Isso evita criar usuários duplicados se rodar o seeder duas vezes
        $existingUsers = $this->db->table('usuarios')->countAllResults();
        
        if ($existingUsers > 0) {
            // Se já existem usuários, não cria novamente
            echo "Usuários já existem na tabela. Pulando seed.\n";
            return; // Interrompe a execução
        }

        // Prepara os dados dos usuários que serão criados
        // $data é um array de arrays (cada array interno representa um usuário)
        $data = [
            // Primeiro usuário: Administrador
            [
                'nome'  => 'Administrador',           // Nome do usuário
                'email' => 'admin@sistema.com',       // Email (deve ser único)
                
                // IMPORTANTE: Senha é criptografada antes de salvar
                // password_hash() cria um hash seguro da senha
                // PASSWORD_DEFAULT = Usa o algoritmo mais seguro disponível
                // O hash gerado será algo como: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
                // Senha original: '123456'
                'senha' => password_hash('123456', PASSWORD_DEFAULT), 
                
                'tipo'  => 'admin',                   // Tipo: administrador
            ],
            
            // Segundo usuário: Corretor padrão
            [
                'nome'  => 'Usuário Padrão',          // Nome do usuário
                'email' => 'user@sistema.com',        // Email (deve ser único)
                
                // Senha também é criptografada
                // Senha original: '123456'
                'senha' => password_hash('123456', PASSWORD_DEFAULT), 
                
                'tipo'  => 'corretor',                // Tipo: corretor
            ],
        ];

        // Insere os dados no banco de dados
        // table('usuarios') = Seleciona a tabela 'usuarios'
        // insertBatch($data) = Faz INSERT de múltiplos registros de uma vez
        // 
        // insertBatch() é mais eficiente que fazer vários insert() individuais
        // Equivale a: INSERT INTO usuarios (nome, email, senha, tipo) VALUES (...), (...)
        $this->db->table('usuarios')->insertBatch($data);
        
        // Exibe mensagem de sucesso
        echo "Usuários criados com sucesso!\n";
    }
}

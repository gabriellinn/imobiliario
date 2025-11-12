<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        // Verifica se a tabela existe
        if (!$this->db->tableExists('usuarios')) {
            echo "Tabela 'usuarios' não existe. Execute as migrations primeiro.\n";
            return;
        }

        // Verifica se já existem usuários para evitar duplicatas
        $existingUsers = $this->db->table('usuarios')->countAllResults();
        if ($existingUsers > 0) {
            echo "Usuários já existem na tabela. Pulando seed.\n";
            return;
        }

        // Define os dados do admin
        $data = [
            [
            'nome'  => 'Administrador', // Você pode mudar o nome se quiser
            'email' => 'admin@sistema.com',
            
            // IMPORTANTE: Cria um hash seguro da senha
            'senha' => password_hash('123456', PASSWORD_DEFAULT), 
            
            'tipo'  => 'admin',
            ],
            [
            'nome'  => 'Usuário Padrão', // Você pode mudar o nome se quiser
            'email' => 'user@sistema.com',
            
            // IMPORTANTE: Cria um hash seguro da senha
            'senha' => password_hash('123456', PASSWORD_DEFAULT), 
            
            'tipo'  => 'corretor',
            ],
        ];


        // Insere os dados no banco (usa insertBatch para múltiplos registros)
        $this->db->table('usuarios')->insertBatch($data);
        
        echo "Usuários criados com sucesso!\n";
    }
}
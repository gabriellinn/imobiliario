<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        // Pega a instância do Query Builder para a tabela 'usuarios'
        $builder = $this->db->table('usuarios');

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


        // Insere os dados no banco
        $builder->insert($data);
        
    }
}
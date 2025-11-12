<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuario extends Migration
{
    public function up()
    {
        // Check if table already exists
        if ($this->db->tableExists('usuarios')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
                'unique'     => true,
            ],
            
            'senha' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],

            'tipo' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'corretor'],
                'null'       => false,
            ]
        ]);

        // Adiciona a Chave Primária
        $this->forge->addKey('id', true);
        
        // Cria a tabela
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}

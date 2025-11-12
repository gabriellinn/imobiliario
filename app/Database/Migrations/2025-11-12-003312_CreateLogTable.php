<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogTable extends Migration
{
    public function up()
    {
        // Check if table already exists
        if ($this->db->tableExists('logs')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_usuario' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'action' => [ // <-- Nome do campo como solicitado
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Chave estrangeira ligando logs.id_usuario com usuarios.id
        $this->forge->addForeignKey('id_usuario', 'usuarios', 'id', 'NO ACTION', 'CASCADE');
        
        $this->forge->createTable('logs');
    }

    public function down()
    {
        $this->forge->dropTable('logs');
    }
}
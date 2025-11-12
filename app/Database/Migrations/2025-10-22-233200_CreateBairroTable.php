<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBairroTable extends Migration
{
    public function up()
    {
        // Check if table already exists
        if ($this->db->tableExists('bairros')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'cidade' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'estado' => [
                'type'       => 'CHAR',
                'constraint' => '2',
                'null'       => false,
            ],
            'cep_inicial' => [
                'type'       => 'VARCHAR',
                'constraint' => '9',
                'null'       => false,
            ],
            'cep_final' => [
                'type'       => 'VARCHAR',
                'constraint' => '9',
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bairros');        
    }

    public function down()
    {
        $this->forge->dropTable('bairros');
    }
}


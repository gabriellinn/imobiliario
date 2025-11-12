<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTipoImoveisTable extends Migration
{
    public function up()
    {
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
        'descricao' => [
            'type' => 'TEXT',
            'null' => true,
        ],

       
    ]);

        $this->forge->addKey('id', true);
      
        $this->forge->createTable('tipos_imoveis');
    }

    public function down()
    {
        $this->forge->dropTable('tipos_imoveis');
    }
}

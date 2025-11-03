<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuario extends Migration
{
    public function up()
    {
      $this->forge->addField([
        'id' => [
            'type'=>'INT',
            'constraint'=> '11',
            'unsigned' => true,
            'auto_increment' => true
        ],

        'nome'=> [
            'type' => 'INT',
            'constraint' => '100',
            'unsigned' => true
        ],

        'email' => [
            'type' => 'string',
            'constraint' => '40',
            'unsigned' => true
        ],

        
        'senha' => [
            'type' => 'string',
            'constraint' => '40',
            'unsigned' => true
        ],

        'tipo' => [
            'type' => 'ENUM',
            'constraint' => 'admin, corretor',
            'unsigned' => true
        ]

         ]);
    

        $this->forge->createTable('usuarios');
        

        }   

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}

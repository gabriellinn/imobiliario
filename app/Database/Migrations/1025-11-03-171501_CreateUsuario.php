<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuario extends Migration
{
public function up()
{
    $this->forge->addField([
        'id' => [
            'type'           => 'INT',
            'constraint'     => 11,
            'unsigned'       => true,
            'auto_increment' => true
        ],
        
        'nome' => [ // <-- CORRIGIDO: Era INT, virou VARCHAR
            'type'       => 'VARCHAR',
            'constraint' => '100',
            'null'       => false,
            // 'unsigned' => true, // REMOVIDO (não se aplica a VARCHAR)
        ],

        'email' => [ // <-- CORRIGIDO: Removido 'unsigned'
            'type'       => 'VARCHAR',
            'constraint' => '100', // Aumentado de 40
            // 'unsigned' => true,  // REMOVIDO (não se aplica a VARCHAR)
            'null'       => false,
            'unique'     => true,  // Boa prática para email
        ],
        
        'senha' => [ // <-- CORRIGIDO: Constraint aumentada
            'type'       => 'VARCHAR',
            'constraint' => '255', // MUITO IMPORTANTE para segurança
            'null'       => false,
        ],

        'tipo' => [ // <-- CORRIGIDO: Removido 'unsigned' e constraint virou array
            'type'       => 'ENUM',
            'constraint' => ['admin', 'corretor'], // CORRIGIDO PARA ARRAY
            // 'unsigned' => true,  // REMOVIDO (não se aplica a ENUM)
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

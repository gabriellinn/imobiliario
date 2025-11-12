<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFotosImoveisTable extends Migration
{
    public function up()
    {
        // Check if table already exists
        if ($this->db->tableExists('fotos_imoveis')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'imovel_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nome_arquivo' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'caminho' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'capa' => [
                'type'           => 'BOOLEAN',
                'default'        => false,
                'comment'        => '1 = foto de capa, 0 = normal',
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Chave Estrangeira
        // Isto garante que se um imóvel for apagado, todas as suas fotos são apagadas juntas.
        $this->forge->addForeignKey('imovel_id', 'imoveis', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('fotos_imoveis');
    }

    public function down()
    {
        $this->forge->dropTable('fotos_imoveis');
    }
}


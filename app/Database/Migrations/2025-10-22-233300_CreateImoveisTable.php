<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateImoveisTable extends Migration
{
    public function up()
    {
        // Check if table already exists
        if ($this->db->tableExists('imoveis')) {
            return;
        }

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'tipo_imovel_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'bairro_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'titulo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'descricao' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'preco_venda' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'preco_aluguel' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'finalidade' => [
                'type'       => 'ENUM',
                'constraint' => ['venda', 'aluguel'],
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['disponivel', 'vendido', 'alugado'],
                'default'    => 'disponivel',
            ],
            'dormitorios' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
            ],
            'banheiros' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
            ],
            'garagem' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
            ],
            'area_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'area_construida' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'endereco' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'numero' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'complemento' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'caracteristicas' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'destaque' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Adicionando chaves estrangeiras
        // (Assumindo que você tem tabelas 'usuarios', 'tipos_imoveis' e 'bairros')
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'CASCADE', 'NO ACTION');
        $this->forge->addForeignKey('tipo_imovel_id', 'tipos_imoveis', 'id', 'SET NULL', 'NO ACTION');
        $this->forge->addForeignKey('bairro_id', 'bairros', 'id', 'SET NULL', 'NO ACTION');
        
        $this->forge->createTable('imoveis');
    }

    public function down()
    {
        $this->forge->dropTable('imoveis');
    }
}


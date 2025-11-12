<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TipoImovelSeeder extends Seeder
{
    public function run()
    {
    $this->db->table('tipo_imoveis')->truncate(); // Limpa a tabela antes de inserir novos dados
        // Define os 3 tipos de imóveis
        $data = [
            [
                'nome' => 'Casa',
                'descricao' => 'Residência unifamiliar',
                // Adicione 'created_at' se a sua tabela tiver timestamps automáticos
                // 'created_at' => date('Y-m-d H:i:s') 
            ],
            [
                'nome' => 'Apartamento',
                'descricao' => 'Unidade residencial em um edifício',
                // 'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'nome' => 'Sala Comercial',
                'descricao' => 'Espaço para atividades comerciais',
                // 'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        // Usamos o insertBatch() para inserir múltiplos registos de uma vez
        // Certifique-se que o nome da tabela é 'tipo_imoveis' (plural)
        $this->db->table('tipo_imoveis')->insertBatch($data);
    }
}
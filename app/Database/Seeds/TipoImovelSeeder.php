<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TipoImovelSeeder extends Seeder
{
    public function run()
    {
        // Verifica se a tabela existe
        if (!$this->db->tableExists('tipos_imoveis')) {
            echo "Tabela 'tipos_imoveis' não existe. Execute as migrations primeiro.\n";
            return;
        }

        // Limpa a tabela antes de inserir novos dados
        // Não podemos usar truncate() porque a tabela tem foreign keys
        // Então desabilitamos temporariamente as foreign keys, truncamos, e reabilitamos
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        $this->db->table('tipos_imoveis')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
        
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

        // Usamos o insertBatch() para inserir múltiplos registros de uma vez
        // Certifique-se que o nome da tabela é 'tipos_imoveis' (plural)
        $this->db->table('tipos_imoveis')->insertBatch($data);
        
        echo "Tipos de imóveis criados com sucesso!\n";
    }
}
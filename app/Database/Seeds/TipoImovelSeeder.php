<?php

namespace App\Database\Seeds;

// Importa a classe base Seeder do CodeIgniter
use CodeIgniter\Database\Seeder;

/**
 * TipoImovelSeeder - Cria Tipos de Imóveis
 * 
 * Este seeder cria os tipos básicos de imóveis:
 * - Casa
 * - Apartamento
 * - Sala Comercial
 * 
 * IMPORTANTE:
 * Este seeder limpa a tabela antes de inserir novos dados.
 * Para fazer isso com tabelas que têm foreign keys, precisamos
 * desabilitar temporariamente as verificações de foreign key.
 */
class TipoImovelSeeder extends Seeder
{
    /**
     * Executa o seeder
     * 
     * FLUXO:
     * 1. Verifica se a tabela existe
     * 2. Desabilita verificação de foreign keys
     * 3. Limpa a tabela (truncate)
     * 4. Reabilita verificação de foreign keys
     * 5. Insere os novos dados
     * 
     * @return void
     * 
     * DE ONDE VEM?
     * - query() = Método do Database para executar SQL direto
     * - truncate() = Método do Query Builder para limpar tabela
     * - insertBatch() = Método do Query Builder para inserir múltiplos registros
     */
    public function run()
    {
        // Verifica se a tabela existe
        if (!$this->db->tableExists('tipos_imoveis')) {
            echo "Tabela 'tipos_imoveis' não existe. Execute as migrations primeiro.\n";
            return;
        }

        // IMPORTANTE: Como a tabela tipos_imoveis tem foreign keys (imoveis.tipo_imovel_id referencia tipos_imoveis.id),
        // não podemos simplesmente fazer truncate() porque isso geraria erro de foreign key constraint.
        // 
        // SOLUÇÃO: Desabilitar temporariamente as verificações de foreign key, truncar, e reabilitar.
        
        // Desabilita verificação de foreign keys
        // SET FOREIGN_KEY_CHECKS=0 = Comando MySQL/MariaDB para desabilitar verificações
        // Isso permite truncar tabelas que têm foreign keys referenciando elas
        $this->db->query('SET FOREIGN_KEY_CHECKS=0');
        
        // Limpa a tabela (remove todos os registros)
        // truncate() é mais rápido que DELETE FROM porque:
        // - Remove todos os registros de uma vez
        // - Reseta o auto_increment
        // - Mas NÃO funciona com foreign keys ativas (por isso desabilitamos acima)
        $this->db->table('tipos_imoveis')->truncate();
        
        // Reabilita verificação de foreign keys
        // SET FOREIGN_KEY_CHECKS=1 = Reabilita as verificações
        // É importante reabilitar para manter a integridade dos dados
        $this->db->query('SET FOREIGN_KEY_CHECKS=1');
        
        // Prepara os dados dos tipos de imóveis
        $data = [
            [
                'nome' => 'Casa',                              // Nome do tipo
                'descricao' => 'Residência unifamiliar',      // Descrição
            ],
            [
                'nome' => 'Apartamento',
                'descricao' => 'Unidade residencial em um edifício',
            ],
            [
                'nome' => 'Sala Comercial',
                'descricao' => 'Espaço para atividades comerciais',
            ],
        ];

        // Insere os dados no banco
        // insertBatch() insere todos os registros de uma vez (mais eficiente)
        $this->db->table('tipos_imoveis')->insertBatch($data);
        
        echo "Tipos de imóveis criados com sucesso!\n";
    }
}

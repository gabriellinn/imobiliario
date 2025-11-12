<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\BairroModel;

/**
 * Seeder para popular a tabela de bairros com dados de exemplo
 * 
 * Este seeder cria vários bairros da cidade de São Paulo.
 * Evita duplicatas verificando se o bairro já existe (pelo nome) antes de inserir.
 */
class BairroSeeder extends Seeder
{
    /**
     * Executa o seeder
     * 
     * @return void
     */
    public function run(): void
    {
        // Valida se a tabela existe
        if (!$this->validarTabelaExiste()) {
            return;
        }

        // Inicializa o modelo
        $bairroModel = new BairroModel();

        // Obtém os dados dos bairros que serão criados
        $bairrosParaCriar = $this->obterDadosBairros();

        // Cria os bairros no banco de dados
        $resultado = $this->criarBairros($bairrosParaCriar, $bairroModel);

        echo "✓ Bairros processados: {$resultado['criados']} criados, {$resultado['pulados']} já existiam.\n";
    }

    /**
     * Valida se a tabela de bairros existe no banco de dados
     * 
     * @return bool Retorna true se a tabela existe, false caso contrário
     */
    private function validarTabelaExiste(): bool
    {
        if (!$this->db->tableExists('bairros')) {
            echo "✗ Erro: Tabela 'bairros' não existe. Execute as migrations primeiro.\n";
            return false;
        }

        return true;
    }

    /**
     * Retorna um array com os dados de todos os bairros que serão criados
     * 
     * @return array Array com os dados de cada bairro
     */
    private function obterDadosBairros(): array
    {
        return [
            [
                'nome' => 'Centro',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep_inicial' => '01000-000',
                'cep_final' => '01099-999',
            ],
            [
                'nome' => 'Jardim das Flores',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep_inicial' => '02000-000',
                'cep_final' => '02099-999',
            ],
            [
                'nome' => 'Vila Nova',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep_inicial' => '03000-000',
                'cep_final' => '03099-999',
            ],
            [
                'nome' => 'Alto da Boa Vista',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep_inicial' => '04000-000',
                'cep_final' => '04099-999',
            ],
            [
                'nome' => 'Parque das Árvores',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep_inicial' => '05000-000',
                'cep_final' => '05099-999',
            ],
            [
                'nome' => 'Bela Vista',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep_inicial' => '06000-000',
                'cep_final' => '06099-999',
            ],
        ];
    }

    /**
     * Cria os bairros no banco de dados
     * 
     * Verifica se cada bairro já existe (pelo nome) antes de inserir.
     * Se já existir, pula a inserção.
     * 
     * @param array $bairrosParaCriar Array com os dados dos bairros
     * @param BairroModel $bairroModel Modelo de bairro para inserção
     * @return array Array com a quantidade de criados e pulados
     */
    private function criarBairros(array $bairrosParaCriar, BairroModel $bairroModel): array
    {
        $criados = 0;
        $pulados = 0;

        foreach ($bairrosParaCriar as $dadosBairro) {
            // Verifica se o bairro já existe pelo nome
            $bairroExistente = $bairroModel->where('nome', $dadosBairro['nome'])->first();

            if ($bairroExistente) {
                // Se já existe, pula este bairro
                $pulados++;
            } else {
                // Se não existe, cria o novo bairro
                try {
                    $bairroModel->insert($dadosBairro);
                    $criados++;
                } catch (\Exception $e) {
                    echo "✗ Erro ao criar bairro '{$dadosBairro['nome']}': {$e->getMessage()}\n";
                }
            }
        }

        return [
            'criados' => $criados,
            'pulados' => $pulados,
        ];
    }
}

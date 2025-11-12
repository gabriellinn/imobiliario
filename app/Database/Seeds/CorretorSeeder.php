<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UsuarioModel;

/**
 * Seeder para popular a tabela de usuários com corretores de exemplo
 * 
 * Este seeder cria vários corretores com dados de exemplo.
 * Evita duplicatas verificando se o email já existe antes de inserir.
 */
class CorretorSeeder extends Seeder
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
        $usuarioModel = new UsuarioModel();

        // Obtém os dados dos corretores que serão criados
        $corretoresParaCriar = $this->obterDadosCorretores();

        // Cria os corretores no banco de dados
        $resultado = $this->criarCorretores($corretoresParaCriar, $usuarioModel);

        echo "✓ Corretores processados: {$resultado['criados']} criados, {$resultado['pulados']} já existiam.\n";
    }

    /**
     * Valida se a tabela de usuários existe no banco de dados
     * 
     * @return bool Retorna true se a tabela existe, false caso contrário
     */
    private function validarTabelaExiste(): bool
    {
        if (!$this->db->tableExists('usuarios')) {
            echo "✗ Erro: Tabela 'usuarios' não existe. Execute as migrations primeiro.\n";
            return false;
        }

        return true;
    }

    /**
     * Retorna um array com os dados de todos os corretores que serão criados
     * 
     * @return array Array com os dados de cada corretor
     */
    private function obterDadosCorretores(): array
    {
        return [
            [
                'nome' => 'João Silva',
                'email' => 'joao.silva@imobiliaria.com',
                'senha' => '123456',
                'tipo' => 'corretor',
            ],
            [
                'nome' => 'Maria Santos',
                'email' => 'maria.santos@imobiliaria.com',
                'senha' => '123456',
                'tipo' => 'corretor',
            ],
            [
                'nome' => 'Pedro Oliveira',
                'email' => 'pedro.oliveira@imobiliaria.com',
                'senha' => '123456',
                'tipo' => 'corretor',
            ],
            [
                'nome' => 'Ana Costa',
                'email' => 'ana.costa@imobiliaria.com',
                'senha' => '123456',
                'tipo' => 'corretor',
            ],
            [
                'nome' => 'Carlos Ferreira',
                'email' => 'carlos.ferreira@imobiliaria.com',
                'senha' => '123456',
                'tipo' => 'corretor',
            ],
        ];
    }

    /**
     * Cria os corretores no banco de dados
     * 
     * Verifica se cada corretor já existe (pelo email) antes de inserir.
     * Se já existir, pula a inserção.
     * 
     * @param array $corretoresParaCriar Array com os dados dos corretores
     * @param UsuarioModel $usuarioModel Modelo de usuário para inserção
     * @return array Array com a quantidade de criados e pulados
     */
    private function criarCorretores(array $corretoresParaCriar, UsuarioModel $usuarioModel): array
    {
        $criados = 0;
        $pulados = 0;

        foreach ($corretoresParaCriar as $dadosCorretor) {
            // Verifica se o corretor já existe pelo email
            $corretorExistente = $usuarioModel->where('email', $dadosCorretor['email'])->first();

            if ($corretorExistente) {
                // Se já existe, pula este corretor
                $pulados++;
            } else {
                // Se não existe, cria o novo corretor
                try {
                    $usuarioModel->insert($dadosCorretor);
                    $criados++;
                } catch (\Exception $e) {
                    echo "✗ Erro ao criar corretor '{$dadosCorretor['nome']}': {$e->getMessage()}\n";
                }
            }
        }

        return [
            'criados' => $criados,
            'pulados' => $pulados,
        ];
    }
}

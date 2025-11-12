<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\ImovelModel;
use App\Models\TipoImovelModel;
use App\Models\BairroModel;
use App\Models\UsuarioModel;

/**
 * Seeder para popular a tabela de imóveis com dados de exemplo
 * 
 * Este seeder cria vários imóveis de exemplo (casas, apartamentos, salas comerciais)
 * e os associa aleatoriamente a tipos de imóveis, bairros e corretores existentes.
 * 
 * IMPORTANTE: Execute os seeders na seguinte ordem:
 * 1. UsuarioSeeder
 * 2. TipoImovelSeeder
 * 3. BairroSeeder
 * 4. CorretorSeeder
 * 5. ImovelSeeder (este)
 */
class ImovelSeeder extends Seeder
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

        // Inicializa os modelos necessários
        $modelos = $this->inicializarModelos();
        
        // Valida se as dependências existem (tipos, bairros, corretores)
        if (!$this->validarDependencias($modelos)) {
            return;
        }

        // Busca os dados necessários para criar os imóveis
        $dadosNecessarios = $this->buscarDadosNecessarios($modelos);
        
        // Obtém a lista de imóveis para criar
        $imoveisParaCriar = $this->obterDadosImoveis();
        
        // Cria os imóveis no banco de dados
        $quantidadeCriada = $this->criarImoveis($imoveisParaCriar, $dadosNecessarios, $modelos['imovel']);
        
        echo "✓ {$quantidadeCriada} imóveis criados com sucesso!\n";
    }

    /**
     * Valida se a tabela de imóveis existe no banco de dados
     * 
     * @return bool Retorna true se a tabela existe, false caso contrário
     */
    private function validarTabelaExiste(): bool
    {
        if (!$this->db->tableExists('imoveis')) {
            echo "✗ Erro: Tabela 'imoveis' não existe. Execute as migrations primeiro.\n";
            return false;
        }
        
        return true;
    }

    /**
     * Inicializa e retorna todos os modelos necessários
     * 
     * @return array Array associativo com os modelos inicializados
     */
    private function inicializarModelos(): array
    {
        return [
            'imovel' => new ImovelModel(),
            'tipo_imovel' => new TipoImovelModel(),
            'bairro' => new BairroModel(),
            'usuario' => new UsuarioModel(),
        ];
    }

    /**
     * Valida se todas as dependências necessárias existem no banco
     * 
     * @param array $modelos Array com os modelos inicializados
     * @return bool Retorna true se todas as dependências existem
     */
    private function validarDependencias(array $modelos): bool
    {
        // Verifica se existem tipos de imóveis
        $tiposImoveis = $modelos['tipo_imovel']->findAll();
        if (empty($tiposImoveis)) {
            echo "✗ Erro: Nenhum tipo de imóvel encontrado. Execute TipoImovelSeeder primeiro.\n";
            return false;
        }

        // Verifica se existem bairros
        $bairros = $modelos['bairro']->findAll();
        if (empty($bairros)) {
            echo "✗ Erro: Nenhum bairro encontrado. Execute BairroSeeder primeiro.\n";
            return false;
        }

        // Verifica se existem corretores
        $corretores = $modelos['usuario']->where('tipo', 'corretor')->findAll();
        if (empty($corretores)) {
            echo "✗ Erro: Nenhum corretor encontrado. Execute CorretorSeeder primeiro.\n";
            return false;
        }

        return true;
    }

    /**
     * Busca todos os dados necessários para criar os imóveis
     * 
     * @param array $modelos Array com os modelos inicializados
     * @return array Array associativo com tipos, bairros e corretores
     */
    private function buscarDadosNecessarios(array $modelos): array
    {
        return [
            'tipos_imoveis' => $modelos['tipo_imovel']->findAll(),
            'bairros' => $modelos['bairro']->findAll(),
            'corretores' => $modelos['usuario']->where('tipo', 'corretor')->findAll(),
        ];
    }

    /**
     * Retorna um array com os dados de todos os imóveis que serão criados
     * 
     * @return array Array com os dados de cada imóvel
     */
    private function obterDadosImoveis(): array
    {
        return [
            [
                'titulo' => 'Casa Moderna com Piscina',
                'descricao' => 'Excelente casa moderna com 3 quartos, 2 banheiros, área gourmet e piscina. Localizada em bairro nobre, próxima a escolas e comércio.',
                'preco_venda' => 450000.00,
                'preco_aluguel' => 3500.00,
                'finalidade' => 'venda',
                'status' => 'disponivel',
                'dormitorios' => 3,
                'banheiros' => 2,
                'garagem' => 2,
                'area_total' => 250.00,
                'area_construida' => 180.00,
                'endereco' => 'Rua das Flores',
                'numero' => '123',
                'complemento' => 'Casa 45',
                'caracteristicas' => "Piscina\nÁrea gourmet\nQuintal amplo\nLavanderia\nVaranda",
                'destaque' => 1,
            ],
            [
                'titulo' => 'Apartamento Luxo Centro',
                'descricao' => 'Apartamento de alto padrão no centro da cidade, com vista panorâmica, 2 quartos, 2 banheiros, sala ampla e cozinha integrada.',
                'preco_venda' => 380000.00,
                'preco_aluguel' => 2800.00,
                'finalidade' => 'aluguel',
                'status' => 'disponivel',
                'dormitorios' => 2,
                'banheiros' => 2,
                'garagem' => 1,
                'area_total' => 95.00,
                'area_construida' => 85.00,
                'endereco' => 'Avenida Principal',
                'numero' => '456',
                'complemento' => 'Apto 1201',
                'caracteristicas' => "Vista panorâmica\nPortaria 24h\nAcademia\nPiscina\nSalão de festas",
                'destaque' => 1,
            ],
            [
                'titulo' => 'Casa de Campo Espaçosa',
                'descricao' => 'Chácara com 4 quartos, 3 banheiros, área de lazer completa, horta e pomar. Ideal para quem busca tranquilidade e contato com a natureza.',
                'preco_venda' => 680000.00,
                'preco_aluguel' => null,
                'finalidade' => 'venda',
                'status' => 'disponivel',
                'dormitorios' => 4,
                'banheiros' => 3,
                'garagem' => 3,
                'area_total' => 500.00,
                'area_construida' => 220.00,
                'endereco' => 'Estrada Rural',
                'numero' => 'Km 12',
                'complemento' => 'Sítio Verde',
                'caracteristicas' => "Chácara\nHorta\nPomar\nÁrea de lazer\nCasa de hóspedes",
                'destaque' => 0,
            ],
            [
                'titulo' => 'Sala Comercial Bem Localizada',
                'descricao' => 'Sala comercial em localização privilegiada, próximo ao centro comercial, com boa visibilidade e estacionamento.',
                'preco_venda' => 180000.00,
                'preco_aluguel' => 2500.00,
                'finalidade' => 'venda',
                'status' => 'disponivel',
                'dormitorios' => 0,
                'banheiros' => 1,
                'garagem' => 2,
                'area_total' => 80.00,
                'area_construida' => 75.00,
                'endereco' => 'Rua Comercial',
                'numero' => '789',
                'complemento' => 'Loja 3',
                'caracteristicas' => "Boa localização\nVisibilidade\nEstacionamento\nPronto para uso",
                'destaque' => 0,
            ],
            [
                'titulo' => 'Apartamento Compacto',
                'descricao' => 'Apartamento compacto e aconchegante, ideal para solteiros ou casais. 1 quarto, 1 banheiro, cozinha e sala integradas.',
                'preco_venda' => 220000.00,
                'preco_aluguel' => 1500.00,
                'finalidade' => 'aluguel',
                'status' => 'disponivel',
                'dormitorios' => 1,
                'banheiros' => 1,
                'garagem' => 1,
                'area_total' => 45.00,
                'area_construida' => 42.00,
                'endereco' => 'Rua Residencial',
                'numero' => '321',
                'complemento' => 'Apto 205',
                'caracteristicas' => "Compacto\nBem localizado\nPróximo ao transporte",
                'destaque' => 0,
            ],
            [
                'titulo' => 'Casa Térrea Familiar',
                'descricao' => 'Casa térrea espaçosa com 3 quartos, 2 banheiros, sala ampla, cozinha grande e quintal. Ideal para famílias.',
                'preco_venda' => 320000.00,
                'preco_aluguel' => 2200.00,
                'finalidade' => 'venda',
                'status' => 'disponivel',
                'dormitorios' => 3,
                'banheiros' => 2,
                'garagem' => 2,
                'area_total' => 180.00,
                'area_construida' => 140.00,
                'endereco' => 'Rua das Palmeiras',
                'numero' => '654',
                'complemento' => '',
                'caracteristicas' => "Casa térrea\nQuintal\nÁrea de serviço\nLavanderia",
                'destaque' => 1,
            ],
            [
                'titulo' => 'Cobertura Duplex',
                'descricao' => 'Cobertura duplex de luxo com 4 quartos, 3 banheiros, terraço privativo, área gourmet e vista privilegiada.',
                'preco_venda' => 850000.00,
                'preco_aluguel' => 6500.00,
                'finalidade' => 'venda',
                'status' => 'disponivel',
                'dormitorios' => 4,
                'banheiros' => 3,
                'garagem' => 3,
                'area_total' => 280.00,
                'area_construida' => 250.00,
                'endereco' => 'Avenida Premium',
                'numero' => '1000',
                'complemento' => 'Cobertura',
                'caracteristicas' => "Cobertura\nTerraço privativo\nÁrea gourmet\nVista privilegiada\nLuxo",
                'destaque' => 1,
            ],
            [
                'titulo' => 'Sobrado Moderno',
                'descricao' => 'Sobrado moderno com 3 quartos, 2 banheiros, sala ampla, cozinha planejada e área de lazer no térreo.',
                'preco_venda' => 520000.00,
                'preco_aluguel' => 3800.00,
                'finalidade' => 'venda',
                'status' => 'disponivel',
                'dormitorios' => 3,
                'banheiros' => 2,
                'garagem' => 2,
                'area_total' => 220.00,
                'area_construida' => 190.00,
                'endereco' => 'Rua dos Jardins',
                'numero' => '888',
                'complemento' => '',
                'caracteristicas' => "Sobrado\nÁrea de lazer\nCozinha planejada\nModerno",
                'destaque' => 0,
            ],
        ];
    }

    /**
     * Cria os imóveis no banco de dados
     * 
     * Para cada imóvel, seleciona aleatoriamente:
     * - Um tipo de imóvel
     * - Um bairro
     * - Um corretor
     * 
     * @param array $imoveisParaCriar Array com os dados dos imóveis
     * @param array $dadosNecessarios Array com tipos, bairros e corretores disponíveis
     * @param ImovelModel $imovelModel Modelo de imóvel para inserção
     * @return int Quantidade de imóveis criados com sucesso
     */
    private function criarImoveis(
        array $imoveisParaCriar, 
        array $dadosNecessarios, 
        ImovelModel $imovelModel
    ): int {
        $quantidadeCriada = 0;

        foreach ($imoveisParaCriar as $dadosImovel) {
            // Seleciona aleatoriamente um tipo de imóvel, bairro e corretor
            $tipoImovelSelecionado = $this->selecionarAleatorio($dadosNecessarios['tipos_imoveis']);
            $bairroSelecionado = $this->selecionarAleatorio($dadosNecessarios['bairros']);
            $corretorSelecionado = $this->selecionarAleatorio($dadosNecessarios['corretores']);

            // Prepara os dados do imóvel para inserção no banco
            $dadosParaInserir = $this->prepararDadosImovel(
                $dadosImovel,
                $tipoImovelSelecionado,
                $bairroSelecionado,
                $corretorSelecionado
            );

            // Insere o imóvel no banco de dados
            try {
                $imovelModel->insert($dadosParaInserir);
                $quantidadeCriada++;
            } catch (\Exception $e) {
                echo "✗ Erro ao criar imóvel '{$dadosImovel['titulo']}': {$e->getMessage()}\n";
            }
        }

        return $quantidadeCriada;
    }

    /**
     * Seleciona um elemento aleatório de um array
     * 
     * @param array $array Array do qual será selecionado um elemento
     * @return mixed Elemento selecionado aleatoriamente
     */
    private function selecionarAleatorio(array $array)
    {
        return $array[array_rand($array)];
    }

    /**
     * Prepara os dados do imóvel para inserção no banco de dados
     * 
     * Combina os dados do imóvel com os IDs das dependências (tipo, bairro, corretor)
     * 
     * @param array $dadosImovel Dados básicos do imóvel
     * @param array $tipoImovel Tipo de imóvel selecionado
     * @param array $bairro Bairro selecionado
     * @param array $corretor Corretor selecionado
     * @return array Array com todos os dados prontos para inserção
     */
    private function prepararDadosImovel(
        array $dadosImovel,
        array $tipoImovel,
        array $bairro,
        array $corretor
    ): array {
        return [
            // Dados básicos do imóvel
            'titulo' => $dadosImovel['titulo'],
            'descricao' => $dadosImovel['descricao'],
            'preco_venda' => $dadosImovel['preco_venda'],
            'preco_aluguel' => $dadosImovel['preco_aluguel'],
            'finalidade' => $dadosImovel['finalidade'],
            'status' => $dadosImovel['status'],
            
            // Características físicas
            'dormitorios' => $dadosImovel['dormitorios'],
            'banheiros' => $dadosImovel['banheiros'],
            'garagem' => $dadosImovel['garagem'],
            'area_total' => $dadosImovel['area_total'],
            'area_construida' => $dadosImovel['area_construida'],
            
            // Endereço
            'endereco' => $dadosImovel['endereco'],
            'numero' => $dadosImovel['numero'],
            'complemento' => $dadosImovel['complemento'],
            
            // Informações adicionais
            'caracteristicas' => $dadosImovel['caracteristicas'],
            'destaque' => $dadosImovel['destaque'],
            
            // Relacionamentos (Foreign Keys)
            'tipo_imovel_id' => $tipoImovel['id'],
            'bairro_id' => $bairro['id'],
            'usuario_id' => $corretor['id'],
        ];
    }
}

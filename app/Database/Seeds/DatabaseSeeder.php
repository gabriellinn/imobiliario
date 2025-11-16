<?php

namespace App\Database\Seeds;

// Importa a classe base Seeder do CodeIgniter
// Todos os seeders devem estender esta classe
use CodeIgniter\Database\Seeder;

/**
 * DatabaseSeeder - Seeder Principal
 * 
 * O QUE É UM SEEDER?
 * Seeder = "Semeador" ou "Populador" de dados
 * É uma forma de inserir dados iniciais no banco de dados.
 * Útil para criar dados de teste, usuários padrão, configurações iniciais, etc.
 * 
 * COMO FUNCIONA?
 * O método run() é executado quando você roda: php spark db:seed DatabaseSeeder
 * Ele chama outros seeders na ordem correta.
 * 
 * POR QUE USAR?
 * - Permite popular o banco com dados de teste rapidamente
 * - Facilita criar o ambiente de desenvolvimento
 * - Permite recriar dados iniciais após limpar o banco
 * - Facilita testes automatizados
 * 
 * ORDEM É IMPORTANTE!
 * Os seeders devem ser executados em uma ordem que respeite as dependências:
 * 1. UsuarioSeeder primeiro (cria usuários básicos)
 * 2. TipoImovelSeeder (cria tipos de imóveis)
 * 3. BairroSeeder (cria bairros)
 * 4. CorretorSeeder (cria corretores - precisa de tabela usuarios)
 * 5. ImovelSeeder por último (cria imóveis - precisa de tipos, bairros e corretores)
 * 
 * COMO EXECUTAR?
 * php spark db:seed DatabaseSeeder
 * ou
 * php spark db:seed UsuarioSeeder  (para executar apenas um seeder)
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Executa todos os seeders na ordem correta
     * 
     * DE ONDE VEM?
     * - call() = Método herdado da classe Seeder
     *   Executa outro seeder pelo nome da classe
     * 
     * @return void
     */
    public function run()
    {
        // Executa o UsuarioSeeder primeiro
        // Cria usuários básicos (admin e usuário padrão)
        $this->call('UsuarioSeeder');
        
        // Executa o TipoImovelSeeder
        // Cria tipos de imóveis (Casa, Apartamento, Sala Comercial)
        $this->call('TipoImovelSeeder');
        
        // Executa o BairroSeeder
        // Cria bairros de exemplo
        $this->call('BairroSeeder');
        
        // Executa o CorretorSeeder
        // Cria corretores de exemplo (precisa que a tabela usuarios exista)
        $this->call('CorretorSeeder');
        
        // Executa o ImovelSeeder por último
        // Cria imóveis de exemplo (precisa de tipos, bairros e corretores)
        $this->call('ImovelSeeder');
        
        // Exibe mensagem de sucesso
        // echo = Função do PHP para imprimir texto no console
        echo "\nTodos os seeders foram executados com sucesso!\n";
    }
}

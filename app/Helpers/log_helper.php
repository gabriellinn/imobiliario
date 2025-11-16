<?php

/**
 * Helper de Log - Função Auxiliar para Registrar Ações
 * 
 * O QUE É UM HELPER?
 * Helpers são funções auxiliares que facilitam tarefas comuns.
 * Eles ficam disponíveis globalmente em toda a aplicação.
 * 
 * COMO USAR?
 * Uma vez carregado (no BaseController via $helpers = ['log']),
 * você pode chamar registrar_log() de qualquer lugar:
 * 
 * registrar_log(1, 'Usuário fez login');
 * 
 * ONDE FICA OS LOGS?
 * Os logs são salvos na tabela 'logs' do banco de dados.
 * Cada log contém: id, id_usuario, action, created_at
 */

/**
 * Verifica se a função já existe (evita erro de redefinição)
 * 
 * Se o helper já foi carregado antes, não cria novamente.
 * Isso evita erro "Cannot redeclare function"
 */
if (! function_exists('registrar_log')) {
    
    /**
     * Registra uma ação no log do sistema
     * 
     * PADRÃO REST (CRUD):
     * - CREATE: "Cadastrou novo [recurso]"
     * - UPDATE: "Atualizou [recurso] ID: X"
     * - DELETE: "Excluiu [recurso] ID: X"
     * - READ: "Visualizou [recurso] ID: X"
     * 
     * @param int $id_usuario ID do usuário que realizou a ação
     * @param string $action Descrição da ação realizada (ex: "Cadastrou novo imóvel")
     * @return void Não retorna nada, apenas salva no banco
     * 
     * DE ONDE VEM?
     * - \Config\Database::connect() = Método estático do CodeIgniter
     *   Retorna uma instância da conexão com o banco de dados
     * - date() = Função nativa do PHP para obter data/hora atual
     *   Formato 'Y-m-d H:i:s' = 2025-01-15 14:30:45
     * - ->table()->insert() = Query Builder do CodeIgniter
     *   Faz um INSERT INTO na tabela especificada
     */
    function registrar_log(int $id_usuario, string $action)
    {
        // Pega a instância do banco de dados
        // \Config\Database é uma classe do CodeIgniter que gerencia conexões
        // connect() retorna uma conexão ativa com o banco
        // O '\' no início significa que é do namespace raiz
        $db = \Config\Database::connect();

        // Prepara os dados para inserir na tabela 'logs'
        $data = [
            'id_usuario' => $id_usuario,           // Quem fez a ação
            'action'     => $action,               // O que foi feito
            'created_at' => date('Y-m-d H:i:s'),   // Quando foi feito (data/hora atual)
        ];

        // Insere os dados na tabela 'logs'
        // table('logs') = Seleciona a tabela 'logs'
        // insert($data) = Faz INSERT INTO logs (id_usuario, action, created_at) VALUES (...)
        // 
        // Query Builder = Interface do CodeIgniter para construir queries SQL
        // É mais seguro que escrever SQL manualmente (protege contra SQL Injection)
        $db->table('logs')->insert($data);
    }
}

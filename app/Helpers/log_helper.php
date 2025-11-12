<?php

/**
 * Registra uma nova ação no log do sistema.
 *
 * @param int    $id_usuario O ID do usuário que realizou a ação.
 * @param string $action     Descrição da ação (ex: "Fez login", "Cadastrou imóvel ID 123").
 */
if (! function_exists('registrar_log')) {
    
    function registrar_log(int $id_usuario, string $action)
    {
        // Pega a instância do banco de dados
        $db = \Config\Database::connect();

        $data = [
            'id_usuario' => $id_usuario,
            'action'     => $action,
            'created_at' => date('Y-m-d H:i:s'), // Data e hora atual
        ];

        // Insere os dados na tabela 'logs'p
        $db->table('logs')->insert($data);
    }
}
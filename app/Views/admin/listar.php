<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <?= $this->include('partials/header') ?>
</head>
<body>

<div>
    <!-- Título corrigido -->
    <h1>Lista de Usuários</h1>

    <!-- Bloco para exibir mensagens de feedback -->
    <?php if (session()->getFlashdata('sucesso')): ?>
        <p><?= esc(session()->getFlashdata('sucesso')) ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('erro')): ?>
        <p><?= esc(session()->getFlashdata('erro')) ?></p>
    <?php endif; ?>

    <!-- 
      * Link corrigido *
      * Aponta para 'admin/formulariocorretor', como definido em Routes.php
    -->
    <a href="<?= site_url('admin/formulariocorretor') ?>">Novo Corretor</a>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Tipo</th> <!-- Adicionada coluna 'Tipo' -->
            <th>Ações</th>
        </tr>
        
        <!-- 
          * Variáveis corrigidas *
          * Loop agora usa $usuarios (enviado pelo controller)
        -->
        <?php if (isset($usuarios) && !empty($usuarios)): ?>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= esc($usuario['id']) ?></td>
                <td><?= esc($usuario['nome']) ?></td>
                <td><?= esc($usuario['email']) ?></td>
                <td><?= esc($usuario['tipo']) ?></td>
                <td>
                    <?php 
                    // Lógica do AdminController:
                    // Só permite editar/excluir se for 'corretor'
                    if ($usuario['tipo'] === 'corretor'): 
                    ?>
                        <!-- 
                          * Links Corrigidos *
                          * Apontam para 'admin/edit' e 'admin/delete', como definido em Routes.php
                        -->
                        <a href="<?= site_url('admin/edit/' . $usuario['id']) ?>">Editar</a> |
                        <a href="<?= site_url('admin/delete/' . $usuario['id']) ?>">Excluir</a>
                    <?php else: ?>
                        <!-- Admin não pode ser editado por aqui -->
                        (Admin)
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align: center;">Nenhum usuário encontrado.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>


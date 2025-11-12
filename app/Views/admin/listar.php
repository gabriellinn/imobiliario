<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Lista de Usuários</h1>
        </div>

        <?php if (session()->getFlashdata('sucesso')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erro')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('erro')) ?></div>
        <?php endif; ?>

        <div class="actions-bar">
            <a href="<?= site_url('admin/formulariocorretor') ?>" class="btn btn-primary">+ Novo Corretor</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($usuarios) && !empty($usuarios)): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= esc($usuario['id']) ?></td>
                                <td><?= esc($usuario['nome']) ?></td>
                                <td><?= esc($usuario['email']) ?></td>
                                <td>
                                    <span class="badge <?= $usuario['tipo'] == 'admin' ? 'badge-primary' : 'badge-success' ?>">
                                        <?= esc(ucfirst($usuario['tipo'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($usuario['tipo'] === 'corretor'): ?>
                                        <a href="<?= site_url('admin/edit/' . $usuario['id']) ?>" class="btn btn-secondary">Editar</a>
                                        <a href="<?= site_url('admin/delete/' . $usuario['id']) ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                                    <?php else: ?>
                                        <span style="color: var(--text-secondary);">(Admin)</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum usuário encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

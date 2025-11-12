<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Tipos de Imóveis</title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Gerenciar Tipos de Imóveis</h1>
        </div>

        <?php if (session()->getFlashdata('sucesso')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erro')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('erro')) ?></div>
        <?php endif; ?>

        <div class="actions-bar">
            <a href="<?= site_url('admin/tipoimoveis/criar') ?>" class="btn btn-primary">+ Novo Tipo de Imóvel</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($tipos) && !empty($tipos)): ?>
                        <?php foreach ($tipos as $tipo): ?>
                            <tr>
                                <td><?= esc($tipo['id']) ?></td>
                                <td><?= esc($tipo['nome']) ?></td>
                                <td><?= esc($tipo['descricao'] ?? 'Sem descrição') ?></td>
                                <td>
                                    <a href="<?= site_url('admin/tipoimoveis/editar/' . $tipo['id']) ?>" class="btn btn-secondary">Editar</a>
                                    <a href="<?= site_url('admin/tipoimoveis/excluir/' . $tipo['id']) ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhum tipo de imóvel encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>    
            </table>
        </div>
    </div>
</body>
</html>

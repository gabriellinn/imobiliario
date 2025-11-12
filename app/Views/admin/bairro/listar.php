<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Bairros</title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Gerenciar Bairros</h1>
        </div>

        <?php if (session()->getFlashdata('sucesso')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erro')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('erro')) ?></div>
        <?php endif; ?>

        <div class="actions-bar">
            <a href="<?= site_url('admin/bairro/criar') ?>" class="btn btn-primary">+ Novo Bairro</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cidade</th>
                        <th>Estado (UF)</th>
                        <th>CEP Inicial</th>
                        <th>CEP Final</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($bairros) && !empty($bairros)): ?>
                        <?php foreach ($bairros as $bairro): ?>
                            <tr>
                                <td><?= esc($bairro['id']) ?></td>
                                <td><?= esc($bairro['nome']) ?></td>
                                <td><?= esc($bairro['cidade']) ?></td>
                                <td><?= esc($bairro['estado']) ?></td>
                                <td><?= esc($bairro['cep_inicial']) ?></td>
                                <td><?= esc($bairro['cep_final']) ?></td>
                                <td>
                                    <a href="<?= site_url('admin/bairro/editar/' . $bairro['id']) ?>" class="btn btn-secondary">Editar</a>
                                    <a href="<?= site_url('admin/bairro/excluir/' . $bairro['id']) ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhum bairro encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>    
            </table>
        </div>
    </div>
</body>
</html>

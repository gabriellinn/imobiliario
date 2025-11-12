<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Imóveis</title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Meus Imóveis</h1>
        </div>

        <?php if (session()->getFlashdata('sucesso')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erro')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('erro')) ?></div>
        <?php endif; ?>

        <div class="actions-bar">
            <a href="<?= site_url('imovel/cadastrar') ?>" class="btn btn-primary">+ Cadastrar Novo Imóvel</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Preço Venda</th>
                        <th>Preço Aluguel</th>
                        <th>Status</th>
                        <th>Destaque</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($imoveis) && !empty($imoveis)): ?>
                        <?php foreach ($imoveis as $imovel): ?>
                            <tr>
                                <td><?= esc($imovel['id']) ?></td>
                                <td><?= esc($imovel['titulo']) ?></td>
                                <td><?= $imovel['preco_venda'] ? 'R$ ' . number_format($imovel['preco_venda'], 2, ',', '.') : '-' ?></td>
                                <td><?= $imovel['preco_aluguel'] ? 'R$ ' . number_format($imovel['preco_aluguel'], 2, ',', '.') : '-' ?></td>
                                <td><span class="badge badge-success"><?= esc(ucfirst($imovel['status'])) ?></span></td>
                                <td><?= $imovel['destaque'] ? '<span class="badge badge-warning">Sim</span>' : 'Não' ?></td>
                                <td>
                                    <a href="<?= site_url('imovel/editar/' . $imovel['id']) ?>" class="btn btn-secondary">Editar</a>
                                    <a href="<?= site_url('imovel/excluir/' . $imovel['id']) ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este imóvel?');">Excluir</a>
                                    <a href="<?= site_url('imovel/fotos/read/' . $imovel['id']) ?>" class="btn btn-primary">Fotos</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhum imóvel cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

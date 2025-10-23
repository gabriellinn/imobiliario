<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Imóveis</title>
    <?= $this->include('partials/header') ?>
</head>
<body>

<div>
    <h1>Meus Imóveis</h1>

    <!-- Bloco para exibir mensagens de feedback -->
    <?php if (session()->getFlashdata('sucesso')): ?>
        <p><?= esc(session()->getFlashdata('sucesso')) ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('erro')): ?>
        <p><?= esc(session()->getFlashdata('erro')) ?></p>
    <?php endif; ?>

    <!-- Link para criar novo imóvel (rota do ImovelController) -->
    <a href="<?= site_url('imovel/cadastrar') ?>">Cadastrar Novo Imóvel</a>

    <table border="1">
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
            <!-- Loop na variável $imoveis enviada pelo ImovelController -->
            <?php if (isset($imoveis) && !empty($imoveis)): ?>
                <?php foreach ($imoveis as $imovel): ?>
                <tr>
                    <td><?= esc($imovel['id']) ?></td>
                    <td><?= esc($imovel['titulo']) ?></td>
                    <td>R$ <?= esc(number_format($imovel['preco_venda'], 2, ',', '.')) ?></td>
                    <td>R$ <?= esc(number_format($imovel['preco_aluguel'], 2, ',', '.')) ?></td>
                    <td><?= esc(ucfirst($imovel['status'])) // Ex: Disponivel ?></td>
                    <td><?= $imovel['destaque'] ? 'Sim' : 'Não' ?></td>
                    <td>
                        <!-- Links para editar e excluir (rotas do ImovelController) -->
                        <a href="<?= site_url('imoveis/editar/' . $imovel['id']) ?>">Editar</a> |
                        <a href="<?= site_url('imoveis/excluir/' . $imovel['id']) ?>" onclick="return confirm('Tem certeza que deseja excluir este imóvel?');">Excluir</a>
                        <a href="<?= site_url('imovel/fotos/read/' . $imovel['id']) ?>">Gerir Fotos</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Nenhum imóvel cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>


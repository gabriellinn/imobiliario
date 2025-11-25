<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Bem-vindo ao Dashboard!</h1>
            <p>Olá, <strong><?= esc($usuario['nome']) ?></strong> (<?= esc($usuario['email']) ?>)!</p>
        </div>

        <?php if (session()->getFlashdata('sucesso')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
        <?php endif; ?>

        <div class="grid grid-2">
            <div class="card">
                <h2>Usuários</h2>
                <p>Gerenciar corretores e usuários do sistema</p>
                <a href="<?= base_url('admin/listar') ?>" class="btn btn-primary">Gerenciar Usuários</a>
            </div>

            <div class="card">
                <h2>Imóveis</h2>
                <p>Visualizar e gerenciar imóveis</p>
                <a href="<?= base_url('imovel/listar') ?>" class="btn btn-primary">Gerenciar Imóveis</a>
            </div>

            <div class="card">
                <h2>Tipos de Imóveis</h2>
                <p>Gerenciar tipos de imóveis disponíveis</p>
                <a href="<?= base_url('admin/tipoimoveis/listar') ?>" class="btn btn-primary">Gerenciar Tipos</a>
            </div>

            <div class="card">
                <h2>Bairros</h2>
                <p>Gerenciar bairros e localizações</p>
                <a href="<?= base_url('admin/bairro/listar') ?>" class="btn btn-primary">Gerenciar Bairros</a>
            </div>

             <div class="grid grid-2">
            <div class="card">
                <h2>Logs</h2>
                <p>Visualizar logs do sistema</p>
                <a href="<?= base_url('admin/logs') ?>" class="btn btn-primary">Visualizar Logs</a>
            </div>
        </div>
    </div>
</body>
</html>

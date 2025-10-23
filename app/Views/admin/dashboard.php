<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Dashboard' ?></title>
    <?= $this->include('partials/header') ?>
</head>

<body>

    <div>

        <h1>Bem-vindo ao Dashboard!</h1>

        <p>
            Olá, <strong><?= esc($usuario['nome']); ?></strong> (<?= esc($usuario['email']); ?>)!
        </p>

        <a href="<?= base_url('/logout') ?>">
            Logout
        </a>
        
        <a href="<?= base_url('admin/listar') ?>">
            Lista de Corretores
        </a><br>    
       
        <a href="<?= base_url('imovel/listar') ?>">
            Lista de Imóveis
        </a><br>
        
        <a href="<?= base_url('admin/tipoimoveis/listar') ?>">
            Lista de Tipos de Imóveis
        </a><br>

        <a href="<?= base_url('admin/bairro/listar') ?>">
            Ver Bairros
    </div>
</a><br>

    <?php if (session()->getFlashdata('sucesso')): ?>
        <div>
            <strong>Ocorreram os seguintes erros:</strong>
            <?= session()->getFlashdata('sucesso') ?>
        </div>
    <?php endif; ?>

    

</body>

</html>
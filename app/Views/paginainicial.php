<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?= $this->include('partials/header') ?>
</head>

<body>
    <a href="<?= base_url('/perfil') ?>"> Meu Perfil</a>
    <h1>Página Inicial do Corretor</h1>
    <a href="<?= base_url('/login') ?>">
        Login
    </a><br>

    <a href="<?= base_url('/logout') ?>">
        Logout
    </a><br>

    <a href="<?= base_url('imovel/listar') ?>">
        Ver imóveis
    </a><br>
</body>

</html>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo ao Dashboard!</h1>
    <p>Olá, <?= esc($usuario['nome']); ?> (<?= esc($usuario['email']); ?>)!</p>

     <a href="<?= base_url('/logout') ?>">Logout</a>
</body>
</html>

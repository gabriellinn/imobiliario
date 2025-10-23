<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <?= $this->include('partials/header') ?>
</head>

<body>
    <h1>Meu Perfil</h1>

    <p>id: <?= esc($usuario['id']); ?></p>
    <p>Nome: <?= esc($usuario['nome']); ?></p>
    <p>Email: <?= esc($usuario['email']); ?></p>
    <p>Tipo: <?= esc($usuario['tipo']); ?></p>

</body>

</html>
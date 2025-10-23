<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar um tipo de imóvel</title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <form action="<?= base_url('tipoimoveis/store') ?>" method="post">
        <label for="nome">Nome do Tipo de Imóvel:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao"></textarea><br>

        <button type="submit">Salvar Alterações</button>
</form>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tipos de Imóveis</title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <h1>Lista de Tipos de Imóveis</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Tipo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tipos as $tipo): ?>
                <tr>
                    <td><?= esc($tipo['id']); ?></td>
                    <td><?= esc($tipo['nome']); ?></td>
                    <td>
                        <a href="<?= base_url('admin/tipoimoveis/edit/' . $tipo['id']); ?>">Editar</a>
                        |
                        <a href="<?= base_url('admin/tipoimoveis/delete/' . $tipo['id']); ?>" onclick="return confirm('Tem certeza que deseja excluir este tipo de imóvel?');">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
</body>
</html>
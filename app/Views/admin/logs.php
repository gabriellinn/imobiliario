<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs de Usuário</title>
    <?= $this->include('partials/header') ?>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <h1>Logs de Atividade</h1>

    <?php if (!empty($logs) && is_array($logs)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário ID</th>
                    <th>Ação</th>
                    <th>Data/Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= esc($log['id']) ?></td>
                        <td><?= esc($log['id_usuario']) ?></td>
                        <td><?= esc($log['action']) ?></td>
                        <td><?= esc($log['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum log encontrado.</p>
    <?php endif; ?>

</body>
</html>
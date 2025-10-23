<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Bairros</title>
</head>
<body>
    <?= $this->include('partials/header') ?>

    <div style="padding: 20px;">
        <h2>Gerenciar Bairros</h2>

        <!-- Mensagens de Feedback -->
        <?php if (session()->getFlashdata('sucesso')): ?>
            <p style="color: green;"><?= esc(session()->getFlashdata('sucesso')) ?></p>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erro')): ?>
            <p style="color: red;"><?= esc(session()->getFlashdata('erro')) ?></p>
        <?php endif; ?>

        <a href="<?= site_url('admin/bairro/criar') ?>">+ Novo Bairro</a>

        <table border="1" style="width: 100%; margin-top: 20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>Estado (UF)</th>
                    <th>CEP Inicial</th>
                    <th>CEP Final</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($bairros) && !empty($bairros)): ?>
                    <?php foreach ($bairros as $bairro): ?>
                        <tr>
                            <td><?= esc($bairro['id']) ?></td>
                            <td><?= esc($bairro['nome']) ?></td>
                            <td><?= esc($bairro['cidade']) ?></td>
                            <td><?= esc($bairro['estado']) ?></td>
                            <td><?= esc($bairro['cep_inicial']) ?></td>
                            <td><?= esc($bairro['cep_final']) ?></td>
                            <td>
                                <a href="<?= site_url('admin/bairro/editar/' . $bairro['id']) ?>">Editar</a> |
                                <a href="<?= site_url('admin/bairro/excluir/' . $bairro['id']) ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Nenhum bairro encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>    
        </table>
    </div>

</body>
</html>

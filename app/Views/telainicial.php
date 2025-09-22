<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Login - Sistema Imobiliário' ?></title>
</head>
<body>
    <h2>Login</h2>

    <?php if (isset($erro) && $erro): ?>
        <p><strong>Erro:</strong> <?= esc($erro) ?></p>
    <?php endif; ?>

    <?php if (isset($sucesso) && $sucesso): ?>
        <p><strong>Sucesso:</strong> <?= esc($sucesso) ?></p>
    <?php endif; ?>

    <form action="<?= base_url('processarLogin') ?>" method="post">
        <p>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
        </p>

        <p>
            <label for="senha">Senha:</label><br>
            <input type="password" id="senha" name="senha" required>
        </p>

        <p>
            <button type="submit">Entrar</button>
        </p>
    </form>

    <h3>Dados de Teste:</h3>
    <p>
        <strong>Email:</strong> admin@sistema.com<br>
        <strong>Senha:</strong> 123456
    </p>

    <p>
        <a href="<?= base_url('/') ?>">Voltar para o site</a>
    </p>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Imobiliário</title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container container-sm">
        <div class="card" style="max-width: 400px; margin: var(--spacing-xl) auto;">
            <div class="page-header">
                <h1>Login</h1>
            </div>

            <?php if (session()->getFlashdata('erro')): ?>
                <div class="alert alert-error"><?= esc(session()->getFlashdata('erro')) ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('sucesso')): ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
            <?php endif; ?>

            <form action="<?= base_url('processarLogin') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Entrar</button>
                </div>
            </form>

            <div class="card" style="margin-top: var(--spacing-md); background-color: var(--bg-secondary);">
                <h3 style="font-size: 1rem; margin-bottom: var(--spacing-sm);">Dados de Teste:</h3>
                <p style="font-size: 0.875rem; margin: var(--spacing-xs) 0;"><strong>Email:</strong> admin@sistema.com</p>
                <p style="font-size: 0.875rem; margin: var(--spacing-xs) 0;"><strong>Senha:</strong> 123456</p>
            </div>

            <div class="text-center" style="margin-top: var(--spacing-md);">
                <a href="<?= base_url('/') ?>" class="btn btn-secondary">Voltar para o site</a>
            </div>
        </div>
    </div>
</body>
</html>

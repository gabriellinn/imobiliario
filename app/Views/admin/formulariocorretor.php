<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($corretor) && !empty($corretor) ? 'Editar Corretor' : 'Cadastrar Corretor' ?></title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container container-sm">
        <div class="page-header">
            <h1><?= isset($corretor) && !empty($corretor) ? 'Editar Corretor' : 'Cadastrar Corretor' ?></h1>
        </div>

        <?php if (session()->getFlashdata('erro')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('erro')) ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-error">
                <strong>Ocorreram erros:</strong>
                <ul style="margin-top: var(--spacing-xs); padding-left: var(--spacing-md);">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card">
            <?php
                $action_url = isset($corretor) && !empty($corretor) 
                    ? site_url('admin/update/' . $corretor['id']) 
                    : site_url('admin/store');
            ?>

            <form action="<?= $action_url ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" value="<?= old('nome', $corretor['nome'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= old('email', $corretor['email'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" <?= isset($corretor) && !empty($corretor) ? '' : 'required' ?>>
                    <?php if (isset($corretor) && !empty($corretor)): ?>
                        <p style="font-size: 0.875rem; color: var(--text-secondary); margin-top: var(--spacing-xs);">Deixe em branco para manter a senha atual</p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="confirmar_senha">Confirmar Senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" <?= isset($corretor) && !empty($corretor) ? '' : 'required' ?>>
                </div>

                <div class="actions-bar">
                    <button type="submit" class="btn btn-primary"><?= isset($corretor) && !empty($corretor) ? 'Salvar Alterações' : 'Cadastrar' ?></button>
                    <a href="<?= site_url('admin/listar') ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

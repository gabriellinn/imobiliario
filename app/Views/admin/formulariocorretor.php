<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <?= $this->include('partials/header') ?>
    <title>Cadastrar Corretor</title>
</head>

<body>

    <div>

        <div>

            <h2>Cadastrar Corretor</h2>

            <?php if (session()->getFlashdata('erro')): ?>
                <div>
                    <strong>Ocorreram os seguintes erros:</strong>
                    <?= session()->getFlashdata('erro') ?>
                </div>
            <?php endif; ?>

            <form action="<?= isset($dados['id']) ? site_url('update/' . $dados['id']) : site_url('admin/store') ?>" method="post">
    <div>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= old('nome', isset($dados['nome']) ? $dados['nome'] : '') ?>" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= old('email', isset($dados['email']) ? $dados['email'] : '') ?>" required>
    </div>
    <div>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" <?= isset($dados['id']) ? '' : 'required' ?>>
    </div>
    <div>
        <label for="confirmarSenha">Confirmar Senha:</label>
        <input type="password" id="confirmarSenha" name="confirmar_senha" <?= isset($dados['id']) ? '' : 'required' ?>>
    </div>
    <div>
        <button type="submit"><?= isset($dados['id']) ? 'Salvar alterações' : 'Cadastrar' ?></button>
    </div>
</form>

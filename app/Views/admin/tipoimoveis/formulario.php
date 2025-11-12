<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($tipo) ? 'Editar Tipo de Imóvel' : 'Novo Tipo de Imóvel' ?></title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container container-sm">
        <div class="page-header">
            <h1><?= isset($tipo) ? 'Editar Tipo de Imóvel' : 'Novo Tipo de Imóvel' ?></h1>
        </div>

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
                $action_url = isset($tipo) 
                    ? site_url('admin/tipoimoveis/atualizar/' . $tipo['id']) 
                    : site_url('admin/tipoimoveis/salvar');
            ?>

            <form action="<?= $action_url ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="nome">Nome do Tipo de Imóvel</label>
                    <input type="text" id="nome" name="nome" value="<?= old('nome', $tipo['nome'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4"><?= old('descricao', $tipo['descricao'] ?? '') ?></textarea>
                </div>

                <div class="actions-bar">
                    <button type="submit" class="btn btn-primary"><?= isset($tipo) ? 'Atualizar' : 'Salvar' ?></button>
                    <a href="<?= site_url('admin/tipoimoveis/listar') ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

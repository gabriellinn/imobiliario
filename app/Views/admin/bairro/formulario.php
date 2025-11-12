<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($bairro) ? 'Editar Bairro' : 'Novo Bairro' ?></title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container container-sm">
        <div class="page-header">
            <h1><?= isset($bairro) ? 'Editar Bairro' : 'Novo Bairro' ?></h1>
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
                $action_url = isset($bairro) 
                    ? site_url('admin/bairro/atualizar/' . $bairro['id']) 
                    : site_url('admin/bairro/salvar');
            ?>

            <form action="<?= $action_url ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="nome">Nome do Bairro</label>
                    <input type="text" id="nome" name="nome" value="<?= old('nome', $bairro['nome'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <input type="text" id="cidade" name="cidade" value="<?= old('cidade', $bairro['cidade'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label for="estado">Estado (UF)</label>
                    <input type="text" id="estado" name="estado" value="<?= old('estado', $bairro['estado'] ?? '') ?>" required maxlength="2" style="width: 100px;">
                </div>

                <div class="form-group">
                    <label for="cep_inicial">CEP Inicial</label>
                    <input type="text" id="cep_inicial" name="cep_inicial" value="<?= old('cep_inicial', $bairro['cep_inicial'] ?? '') ?>" required maxlength="9" style="width: 150px;">
                </div>

                <div class="form-group">
                    <label for="cep_final">CEP Final</label>
                    <input type="text" id="cep_final" name="cep_final" value="<?= old('cep_final', $bairro['cep_final'] ?? '') ?>" required maxlength="9" style="width: 150px;">
                </div>

                <div class="actions-bar">
                    <button type="submit" class="btn btn-primary"><?= isset($bairro) ? 'Atualizar' : 'Salvar' ?></button>
                    <a href="<?= site_url('admin/bairro/listar') ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

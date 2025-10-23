    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= isset($bairro) ? 'Editar Bairro' : 'Novo Bairro' ?></title>
    </head>
    <body>
        <?= $this->include('partials/header') ?>

        <div style="padding: 20px;">
            <h2><?= isset($bairro) ? 'Editar Bairro' : 'Novo Bairro' ?></h2>

            <!-- Exibição de Erros de Validação -->
            <?php if (session()->getFlashdata('errors')): ?>
                <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
                    <strong>Ocorreram erros:</strong>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Formulário -->
            <?php
                // Define a URL da ação do formulário (Salvar ou Atualizar)
                $action_url = isset($bairro) 
                    ? site_url('admin/bairro/atualizar/' . $bairro['id']) 
                    : site_url('admin/bairro/salvar');
            ?>

            <form action="<?= $action_url ?>" method="post">
                <?= csrf_field() ?>

                <div>
                    <label for="nome">Nome do Bairro:</label><br>
                    <input type="text" id="nome" name="nome" value="<?= old('nome', $bairro['nome'] ?? '') ?>" required style="width: 300px;">
                </div>
                <br>
                <div>
                    <label for="cidade">Cidade:</label><br>
                    <input type="text" id="cidade" name="cidade" value="<?= old('cidade', $bairro['cidade'] ?? '') ?>" required style="width: 300px;">
                </div>
                <br>
                <div>
                    <label for="estado">Estado (UF):</label><br>
                    <input type="text" id="estado" name="estado" value="<?= old('estado', $bairro['estado'] ?? '') ?>" required maxlength="2" style="width: 50px;">
                </div>
                <br>
                <div>
                    <label for="cep">CEP Inicial:</label><br>
                    <input type="text" id="cep" name="cep" value="<?= old('cep_inicial', $bairro['cep_inicial'] ?? '') ?>" required maxlength="9" style="width: 100px;">
                </div>
                <br>
                <div>
                    <label for="cep_final">CEP Final:</label><br>
                    <input type="text" id="cep_final" name="cep_final" value="<?= old('cep_final', $bairro['cep_final'] ?? '') ?>" required maxlength="9" style="width: 100px;">

                <button type="submit"><?= isset($bairro) ? 'Atualizar' : 'Salvar' ?></button>
                <a href="<?= site_url('admin/bairro/listar') ?>">Cancelar</a>
            </form>
        </div>

    </body>
    </html>

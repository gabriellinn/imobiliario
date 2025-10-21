<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- O script do TailwindCSS foi removido -->
    <title>Cadastrar Corretor</title>
</head>
<body>

    <div>
    
        <div>

            <h2>Cadastrar Corretor</h2>

            <?php if (session()->getFlashdata('erro')) : ?>
                <div>
                    <strong>Ocorreram os seguintes erros:</strong>
                    <?= session()->getFlashdata('erro') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('cadastrarCorretor')?>" method="post">
                <div>
                    <label for="nome">
                        Nome:
                    </label>
                    <input type="text" id="nome" name="nome" value="<?= old('nome') ?>" required>
                </div>

                <div>
                    <label for="email">
                        Email:
                    </label>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
                </div>

                <div>
                    <label for="senha">
                        Senha:
                    </label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <div>
                    <label for="confirmarSenha">
                        Confirmar Senha:
                    </label>
                    <input type="password" id="confirmarSenha" name="confirmar_senha" required>
                </div>

                <div>
                    <button type="submit">
                        Cadastrar
                    </button>
                </div>
            </form>
            
        </div>
    </div>

</body>
</html>
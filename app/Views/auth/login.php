<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Login - Sistema Imobiliário' ?></title>
    <!-- O script do TailwindCSS foi removido -->
</head>
<body>
 
    <div>
    
        <div>

            <h2>Login</h2>

            <!-- Bloco unificado para exibir erros -->
            <?php if (session()->getFlashdata('erro')) : ?>
                <div>
                    <strong>Ocorreram os seguintes erros:</strong>
                    <?= session()->getFlashdata('erro') ?>
                </div>
            <?php endif; ?>

            <!-- Bloco unificado para exibir sucesso -->
            <?php if (session()->getFlashdata('sucesso')) : ?>
                <div>
                    <strong>Sucesso!</strong>
                    <?= session()->getFlashdata('sucesso') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('processarLogin') ?>" method="post">
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
                    <button type="submit">
                        Entrar
                    </button>
                </div>
            </form>
        </div>

        <div>
            <div>
                <h3>Dados de Admin:</h3>
                <p><strong>Email:</strong> admin@sistema.com</p>
                <p><strong>Senha:</strong> 123456</p>
            </div>
            
            <a href="<?= base_url('/') ?>">
                Voltar para o site
            </a>
        </div>
    </div>

</body>
</html>
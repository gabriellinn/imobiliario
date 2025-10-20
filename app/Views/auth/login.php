<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Login - Sistema Imobiliário' ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-sm">
    
        <div class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">

            <h2 class="text-center text-2xl font-bold text-gray-700 mb-6">Login</h2>

            <?php if (isset($erro) && $erro): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?= esc($erro) ?></span>
                </div>
            <?php endif; ?>

            <?php if (isset($sucesso) && $sucesso): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?= esc($sucesso) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('processarLogin') ?>" method="post">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                        Email:
                    </label>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-6">
                    <label for="senha" class="block text-gray-700 text-sm font-bold mb-2">
                        Senha:
                    </label>
                    <input type="password" id="senha" name="senha" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full focus:outline-none focus:shadow-outline">
                        Entrar
                    </button>
                </div>
            </form>
        </div>

        <div class="text-center text-gray-600 text-sm">
            <div class="bg-gray-200 p-3 rounded-lg mb-4">
                <h3 class="font-bold">Dados de Admin:</h3>
                <p><strong>Email:</strong> admin@sistema.com</p>
                <p><strong>Senha:</strong> 123456</p>
            </div>
            <a href="<?= base_url('/') ?>" class="font-bold text-blue-500 hover:text-blue-800">
                Voltar para o site
            </a>
        </div>
    </div>

</body>
</html>
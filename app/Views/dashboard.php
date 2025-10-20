<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Dashboard' ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-md rounded-lg p-8 text-center w-full max-w-lg">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            Bem-vindo ao Dashboard!
        </h1>
        
        <p class="text-lg text-gray-600 mb-8">
            Olá, <strong class="font-medium text-gray-700"><?= esc($usuario['nome']); ?></strong> (<?= esc($usuario['email']); ?>)!
        </p>

        <a href="<?= base_url('/logout') ?>"
           class="block w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">
            Logout
        </a>
    </div>
    <a href= "<?= base_url(relativePath:'/cadastrarcorretor')?>">Cadastrar Corretor</a>

</body>
</html>
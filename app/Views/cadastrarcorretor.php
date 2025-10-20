<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Corretor</title>
</head>
<body>
    <form action="<?= base_url(relativePath:'cadastrarCorretor')?>">
     <label>Usuário</label><br>
     <input type="text" name="usuario"><br>

     <label for="email"> Email</label><br>
     <input type="email" name="email"><br>

     <label for="senha">Senha</label><br>
     <input type="password"><br>

     <label for="senha">Confirmar senha</label><br>
     <input type="password" name="senha"><br>
</form>
</body>
</html>
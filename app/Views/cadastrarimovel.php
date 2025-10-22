<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?= base_url('/registrarimovel') ?>" method="post">

 <label for="titulo">Título:</label>
 <input type="text" id="titulo" name="titulo" <?= old('titulo') ?> required><br>


 <label for="descricao">Descrição:</label>
 <input type="text" id="descricao" name="descricao" <?= old('descricao') ?> required><br>


 <label for="preco_venda">Preço de Venda:</label>
 <input type="text" id="preco_venda" name="preco_venda" <?= old('preco_venda') ?> required><br>


 <label for="preco_aluguel">Preço de Aluguel:</label>
 <input type="text" id="preco_aluguel" name="preco_aluguel" <?= old('preco_aluguel') ?> required><br>


 <!-- Group 1: Finalidade -->
<label>Finalidade:</label><br>
<input type="radio" id="aluguel" name="dados[finalidade]" value="aluguel" <?= old('finalidade') === 'aluguel' ? 'checked' : '' ?> required>
<label for="aluguel">Aluguel</label>


<input type="radio" id="venda" name="dados[finalidade]" value="venda" <?= old('finalidade') === 'venda' ? 'checked' : '' ?> required>
<label for="venda">Venda</label><br>


<!-- Group 2: Status -->
<label>Status:</label><br>
<input type="radio" id="ocupado" name="dados[status]" value="ocupado" <?= old('status') === 'ocupado' ? 'checked' : '' ?> required>
<label for="ocupado">Ocupado</label>


<input type="radio" id="livre" name="dados[status]" value="livre" <?= old('status') === 'livre' ? 'checked' : '' ?> required>
<label for="livre">Livre</label><br>




<label for="dormitorios">Dormitórios:</label>
<input type="number" id="dormitorios" name="dormitorios" <?= old('dormitorios') ?> required><br>


<label for="banheiros">Banheiros:</label>
<input type="number" id="banheiros" name="banheiros" <?= old('banheiros') ?> required><br>


 <label for="garagem">Garagem:</label>
 <input type="number" id="garagem" name="garagem" <?= old('garagem') ?> required><br>


 <label for="area_total">Área Total:</label>
  <input type="number" id="area_total" name="area_total" <?= old('area_total') ?> required><br>


<label for="area_construida">Área Construída:</label>
 <input type="number" id="area_construida" name="area_construida" <?= old('area_construida') ?> required><br>


<label for="endereco">Endereço:</label>
 <input type="text" id="endereco" name="endereco" <?= old('endereco') ?> required><br>


 <label for="numero">Número da casa:</label>
<input type="number" id="numero" name="numero" <?= old('numero') ?> required><br>


 <label for="complemento">Complemento:</label>
 <input type="text" id="complemento" name="complemento" <?= old('complemento') ?>><br>


 <label for="caracteristicas">Características:</label>
 <input type="text" id="caracteristicas" name="caracteristicas" <?= old('caracteristicas') ?> required><br>


 <label for="destaque">Destaque:</label>
<input type="text" id="destaque" name="destaque" <?= old('destaque') ?> required><br>

 <button type="submit">Cadastrar Imóvel</button>
 </form>
</body>
</html>
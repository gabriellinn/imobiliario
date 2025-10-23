<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- O título agora é dinâmico -->
    <title><?= (empty($imovel)) ? 'Cadastrar' : 'Editar' ?> Imóvel</title>
   <?= $this->include('partials/header') ?>
</head>

<body>
    <h1><?= (empty($imovel)) ? 'Cadastrar Novo Imóvel' : 'Editar Imóvel' ?></h1>

    <!-- Mensagens de Feedback (opcional, mas recomendado) -->
    <?php if (session()->getFlashdata('erro')): ?>
        <div style="color: red; border: 1px solid red; padding: 10px;">
            <?= session()->getFlashdata('erro') ?>
        </div>
    <?php endif; ?>

    <?php
        // Define a URL da ação do formulário (Salvar ou Atualizar)
        $action_url = (empty($imovel)) ? site_url('imoveis/salvar') : site_url('imoveis/atualizar/' . $imovel['id']);
    ?>

    <!-- 1. ACTION ATUALIZADA E CSRF ADICIONADO -->
    <form action="<?= $action_url ?>" method="post">
        <?= csrf_field() ?>

        <div>
            <label for="titulo">Título:</label>
            <!-- 2. VALUE CORRIGIDO E DINÂMICO -->
            <input type="text" id="titulo" name="titulo" value="<?= esc($imovel['titulo'] ?? old('titulo')) ?>" required><br>
        </div>

        <div>
            <label for="descricao">Descrição:</label>
            <!-- Textarea usa o valor entre as tags -->
            <textarea id="descricao" name="descricao" required><?= esc($imovel['descricao'] ?? old('descricao')) ?></textarea><br>
        </div>

        <div>
            <label for="tipo_imovel_id">Tipo de Imóvel:</label><br>
            <select id="tipo_imovel_id" name="tipo_imovel_id" required>
                <!-- 3. SELECTED DINÂMICO E 'name' REMOVIDO DAS OPTIONS -->
                <option value="1" <?= ( ($imovel['tipo_imovel_id'] ?? old('tipo_imovel_id')) == '1' ) ? 'selected' : '' ?>>Casa</option>
                <option value="2" <?= ( ($imovel['tipo_imovel_id'] ?? old('tipo_imovel_id')) == '2' ) ? 'selected' : '' ?>>Apartamento</option>
                <option value="3" <?= ( ($imovel['tipo_imovel_id'] ?? old('tipo_imovel_id')) == '3' ) ? 'selected' : '' ?>>Sala Comercial</option><br>
            </select><br>
        </div>
        
        <div>
            <label for="preco_venda">Preço de Venda:</label>
            <!-- 4. TIPO DE CAMPO CORRIGIDO (text para number) -->
            <input type="number" step="0.01" id="preco_venda" name="preco_venda" value="<?= esc($imovel['preco_venda'] ?? old('preco_venda')) ?>"><br>
        </div>

        <div>
            <label for="preco_aluguel">Preço de Aluguel:</label>
            <input type="number" step="0.01" id="preco_aluguel" name="preco_aluguel" value="<?= esc($imovel['preco_aluguel'] ?? old('preco_aluguel')) ?>"><br>
        </div>

        <div>
            <label for="finalidade">Finalidade:</label><br>
            <select id="finalidade" name="finalidade" required>
                <option value="venda" <?= ( ($imovel['finalidade'] ?? old('finalidade')) == 'venda' ) ? 'selected' : '' ?>>Venda</option>
                <option value="aluguel" <?= ( ($imovel['finalidade'] ?? old('finalidade')) == 'aluguel' ) ? 'selected' : '' ?>>Aluguel</option><br>
            </select><br>
        </div>

        <div>
            <label>Status:</label><br>
             <!-- 5. VALORES DE STATUS ALINHADOS COM O CONTROLLER -->
            <select id="status" name="status" required>
                <option value="disponivel" <?= ( ($imovel['status'] ?? old('status')) == 'disponivel' ) ? 'selected' : '' ?>>Disponível</option>
                <option value="vendido" <?= ( ($imovel['status'] ?? old('status')) == 'vendido' ) ? 'selected' : '' ?>>Vendido</option>
                <option value="alugado" <?= ( ($imovel['status'] ?? old('status')) == 'alugado' ) ? 'selected' : '' ?>>Alugado</option><br>
            </select><br>
        </div>
        
        <div>
            <label for="dormitorios">Dormitórios:</label>
            <input type="number" id="dormitorios" name="dormitorios" value="<?= esc($imovel['dormitorios'] ?? old('dormitorios')) ?>"><br>
        </div>

        <div>
            <label for="banheiros">Banheiros:</label>
            <input type="number" id="banheiros" name="banheiros" value="<?= esc($imovel['banheiros'] ?? old('banheiros')) ?>"><br>
        </div>

        <div>
            <label for="garagem">Garagem:</label>
            <input type="number" id="garagem" name="garagem" value="<?= esc($imovel['garagem'] ?? old('garagem')) ?>"><br>
        </div>

        <div>
            <label for="area_total">Área Total (m²):</label>
            <input type="number" step="0.01" id="area_total" name="area_total" value="<?= esc($imovel['area_total'] ?? old('area_total')) ?>"><br>
        </div>

        <div>
            <label for="area_construida">Área Construída (m²):</label>
            <input type="number" step="0.01" id="area_construida" name="area_construida" value="<?= esc($imovel['area_construida'] ?? old('area_construida')) ?>"><br>
        </div>

        <div>
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" value="<?= esc($imovel['endereco'] ?? old('endereco')) ?>"><br>
        </div>

        <div>
            <label for="numero">Número da casa:</label>
            <input type="number" id="numero" name="numero" value="<?= esc($imovel['numero'] ?? old('numero')) ?>"><br>
        </div>

        <div>
            <label for="complemento">Complemento:</label>
            <input type="text" id="complemento" name="complemento" value="<?= esc($imovel['complemento'] ?? old('complemento')) ?>"><br>
        </div>

        <div>
            <label for="caracteristicas">Características (separadas por vírgula):</label>
            <input type="text" id="caracteristicas" name="caracteristicas" value="<?= esc($imovel['caracteristicas'] ?? old('caracteristicas')) ?>"><br>
        </div>

        <div>
            <label for="destaque">Destaque:</label>
            <!-- 6. CAMPO DESTAQUE CORRIGIDO (text para select) -->
            <select id="destaque" name="destaque" required>
                <option value="0" <?= ( ($imovel['destaque'] ?? old('destaque')) == '0' ) ? 'selected' : '' ?>>Não</option>
                <option value="1" <?= ( ($imovel['destaque'] ?? old('destaque')) == '1' ) ? 'selected' : '' ?>>Sim</option>
            </select><br>
        </div>

        <button type="submit"><?= (empty($imovel)) ? 'Cadastrar' : 'Atualizar' ?> Imóvel</button>
        <a href="<?= site_url('imovel/listar') ?>">Cancelar</a>
    </form>
</body>

</html>


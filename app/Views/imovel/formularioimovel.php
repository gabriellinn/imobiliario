<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (empty($imovel)) ? 'Cadastrar' : 'Editar' ?> Imóvel</title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container container-sm">
        <div class="page-header">
            <h1><?= (empty($imovel)) ? 'Cadastrar Novo Imóvel' : 'Editar Imóvel' ?></h1>
        </div>

        <?php if (session()->getFlashdata('erro')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('erro')) ?></div>
        <?php endif; ?>

        <div class="card">
            <?php
                $action_url = (empty($imovel)) ? site_url('imovel/salvar') : site_url('imovel/atualizar/' . $imovel['id']);
            ?>

            <form action="<?= $action_url ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" value="<?= esc($imovel['titulo'] ?? old('titulo')) ?>" required>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="5" required><?= esc($imovel['descricao'] ?? old('descricao')) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="tipo_imovel_id">Tipo de Imóvel</label>
                    <select id="tipo_imovel_id" name="tipo_imovel_id" required>
                        <option value="">Selecione...</option>
                        <?php
                        $tipoImovelModel = new \App\Models\TipoImovelModel();
                        $tipos = $tipoImovelModel->findAll();
                        foreach ($tipos as $tipo):
                        ?>
                            <option value="<?= $tipo['id'] ?>" <?= (($imovel['tipo_imovel_id'] ?? old('tipo_imovel_id')) == $tipo['id']) ? 'selected' : '' ?>>
                                <?= esc($tipo['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="preco_venda">Preço de Venda</label>
                        <input type="number" step="0.01" id="preco_venda" name="preco_venda" value="<?= esc($imovel['preco_venda'] ?? old('preco_venda')) ?>">
                    </div>

                    <div class="form-group">
                        <label for="preco_aluguel">Preço de Aluguel</label>
                        <input type="number" step="0.01" id="preco_aluguel" name="preco_aluguel" value="<?= esc($imovel['preco_aluguel'] ?? old('preco_aluguel')) ?>">
                    </div>
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="finalidade">Finalidade</label>
                        <select id="finalidade" name="finalidade" required>
                            <option value="">Selecione...</option>
                            <option value="venda" <?= (($imovel['finalidade'] ?? old('finalidade')) == 'venda') ? 'selected' : '' ?>>Venda</option>
                            <option value="aluguel" <?= (($imovel['finalidade'] ?? old('finalidade')) == 'aluguel') ? 'selected' : '' ?>>Aluguel</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="disponivel" <?= (($imovel['status'] ?? old('status')) == 'disponivel') ? 'selected' : '' ?>>Disponível</option>
                            <option value="vendido" <?= (($imovel['status'] ?? old('status')) == 'vendido') ? 'selected' : '' ?>>Vendido</option>
                            <option value="alugado" <?= (($imovel['status'] ?? old('status')) == 'alugado') ? 'selected' : '' ?>>Alugado</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-3">
                    <div class="form-group">
                        <label for="dormitorios">Dormitórios</label>
                        <input type="number" id="dormitorios" name="dormitorios" value="<?= esc($imovel['dormitorios'] ?? old('dormitorios', 0)) ?>" min="0">
                    </div>

                    <div class="form-group">
                        <label for="banheiros">Banheiros</label>
                        <input type="number" id="banheiros" name="banheiros" value="<?= esc($imovel['banheiros'] ?? old('banheiros', 0)) ?>" min="0">
                    </div>

                    <div class="form-group">
                        <label for="garagem">Vagas de Garagem</label>
                        <input type="number" id="garagem" name="garagem" value="<?= esc($imovel['garagem'] ?? old('garagem', 0)) ?>" min="0">
                    </div>
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="area_total">Área Total (m²)</label>
                        <input type="number" step="0.01" id="area_total" name="area_total" value="<?= esc($imovel['area_total'] ?? old('area_total')) ?>">
                    </div>

                    <div class="form-group">
                        <label for="area_construida">Área Construída (m²)</label>
                        <input type="number" step="0.01" id="area_construida" name="area_construida" value="<?= esc($imovel['area_construida'] ?? old('area_construida')) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco" value="<?= esc($imovel['endereco'] ?? old('endereco')) ?>">
                </div>

                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" id="numero" name="numero" value="<?= esc($imovel['numero'] ?? old('numero')) ?>">
                    </div>

                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" id="complemento" name="complemento" value="<?= esc($imovel['complemento'] ?? old('complemento')) ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="caracteristicas">Características Especiais (uma por linha)</label>
                    <textarea id="caracteristicas" name="caracteristicas" rows="4"><?= esc($imovel['caracteristicas'] ?? old('caracteristicas')) ?></textarea>
                </div>

                <div class="form-group">
                    <label>
                        <input type="checkbox" id="destaque" name="destaque" value="1" <?= (($imovel['destaque'] ?? old('destaque')) == 1) ? 'checked' : '' ?>>
                        Destacar este imóvel
                    </label>
                </div>

                <div class="actions-bar">
                    <button type="submit" class="btn btn-primary"><?= (empty($imovel)) ? 'Cadastrar' : 'Atualizar' ?></button>
                    <a href="<?= site_url('imovel/listar') ?>" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

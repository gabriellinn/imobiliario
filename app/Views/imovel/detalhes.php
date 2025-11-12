<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($imovel['titulo']) ?> - Detalhes do Imóvel</title>
    <?= $this->include('partials/header') ?>
    <style>
        .preco-section {
            font-size: 2rem;
            font-weight: 600;
            color: var(--success-color);
            margin: var(--spacing-md) 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--spacing-md);
            margin: var(--spacing-lg) 0;
        }
        .info-card {
            padding: var(--spacing-md);
            background-color: var(--bg-secondary);
            border-radius: var(--radius-md);
        }
        .info-card h3 {
            margin: 0 0 var(--spacing-sm) 0;
            color: var(--text-primary);
            font-size: 1.125rem;
        }
        .info-card p {
            margin: var(--spacing-xs) 0;
            color: var(--text-secondary);
        }
        .fotos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: var(--spacing-md);
            margin-top: var(--spacing-md);
        }
        .foto-item {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .foto-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .foto-capa-badge {
            position: absolute;
            top: var(--spacing-xs);
            right: var(--spacing-xs);
            background-color: var(--warning-color);
            color: #78350f;
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 600;
        }
        .descricao-section,
        .endereco-section {
            margin: var(--spacing-lg) 0;
            padding: var(--spacing-md);
            background-color: var(--bg-secondary);
            border-radius: var(--radius-md);
        }
        .descricao-section h2,
        .endereco-section h2 {
            margin-top: 0;
            color: var(--text-primary);
        }
        .descricao-section p {
            line-height: 1.6;
            color: var(--text-secondary);
            white-space: pre-wrap;
        }
        .caracteristicas-list {
            list-style: none;
            padding: 0;
        }
        .caracteristicas-list li {
            padding: var(--spacing-sm);
            margin: var(--spacing-xs) 0;
            background-color: var(--bg-primary);
            border-radius: var(--radius-sm);
            border-left: 3px solid var(--primary-color);
        }
        .destaque-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--warning-color);
            color: #78350f;
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 600;
            margin-left: var(--spacing-sm);
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= base_url('/') ?>" class="btn btn-secondary">← Voltar</a>

        <?php if (session()->getFlashdata('erro')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('erro')) ?></div>
        <?php endif; ?>

        <div class="page-header">
            <h1>
                <?= esc($imovel['titulo']) ?>
                <?php if ($imovel['destaque']): ?>
                    <span class="destaque-badge">⭐ Destaque</span>
                <?php endif; ?>
            </h1>
            
            <div class="preco-section">
                <?php if (!empty($imovel['finalidade']) && $imovel['finalidade'] == 'venda' && $imovel['preco_venda']): ?>
                    R$ <?= number_format($imovel['preco_venda'], 2, ',', '.') ?>
                <?php elseif (!empty($imovel['finalidade']) && $imovel['finalidade'] == 'aluguel' && $imovel['preco_aluguel']): ?>
                    R$ <?= number_format($imovel['preco_aluguel'], 2, ',', '.') ?>/mês
                <?php elseif ($imovel['preco_venda']): ?>
                    Venda: R$ <?= number_format($imovel['preco_venda'], 2, ',', '.') ?>
                <?php elseif ($imovel['preco_aluguel']): ?>
                    Aluguel: R$ <?= number_format($imovel['preco_aluguel'], 2, ',', '.') ?>/mês
                <?php else: ?>
                    Consulte o preço
                <?php endif; ?>
            </div>

            <div>
                <span class="badge badge-success"><?= esc(ucfirst($imovel['status'])) ?></span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3>Tipo de Imóvel</h3>
                <p><?= $imovel['tipo_imovel'] ? esc($imovel['tipo_imovel']['nome']) : 'Não informado' ?></p>
                <?php if ($imovel['tipo_imovel'] && !empty($imovel['tipo_imovel']['descricao'])): ?>
                    <p style="font-size: 0.875rem; color: var(--text-secondary);"><?= esc($imovel['tipo_imovel']['descricao']) ?></p>
                <?php endif; ?>
            </div>

            <div class="info-card">
                <h3>Localização</h3>
                <?php if ($imovel['bairro']): ?>
                    <p><strong>Bairro:</strong> <?= esc($imovel['bairro']['nome']) ?></p>
                    <p><strong>Cidade:</strong> <?= esc($imovel['bairro']['cidade']) ?></p>
                    <p><strong>Estado:</strong> <?= esc($imovel['bairro']['estado']) ?></p>
                <?php else: ?>
                    <p>Não informado</p>
                <?php endif; ?>
            </div>

            <div class="info-card">
                <h3>Características</h3>
                <?php if ($imovel['dormitorios'] > 0): ?>
                    <p>🛏️ <strong><?= $imovel['dormitorios'] ?></strong> quarto(s)</p>
                <?php endif; ?>
                <?php if ($imovel['banheiros'] > 0): ?>
                    <p>🚿 <strong><?= $imovel['banheiros'] ?></strong> banheiro(s)</p>
                <?php endif; ?>
                <?php if ($imovel['garagem'] > 0): ?>
                    <p>🚗 <strong><?= $imovel['garagem'] ?></strong> vaga(s) de garagem</p>
                <?php endif; ?>
            </div>

            <div class="info-card">
                <h3>Área</h3>
                <?php if ($imovel['area_total']): ?>
                    <p><strong>Total:</strong> <?= number_format($imovel['area_total'], 0, ',', '.') ?> m²</p>
                <?php endif; ?>
                <?php if ($imovel['area_construida']): ?>
                    <p><strong>Construída:</strong> <?= number_format($imovel['area_construida'], 0, ',', '.') ?> m²</p>
                <?php endif; ?>
            </div>

            <div class="info-card">
                <h3>Finalidade</h3>
                <p><?= !empty($imovel['finalidade']) ? esc(ucfirst($imovel['finalidade'])) : 'Não informado' ?></p>
            </div>
        </div>

        <?php if ($imovel['endereco'] || $imovel['numero'] || $imovel['complemento']): ?>
            <div class="endereco-section">
                <h2>📍 Endereço</h2>
                <p>
                    <?php if ($imovel['endereco']): ?>
                        <?= esc($imovel['endereco']) ?>
                    <?php endif; ?>
                    <?php if ($imovel['numero']): ?>
                        , <?= esc($imovel['numero']) ?>
                    <?php endif; ?>
                    <?php if ($imovel['complemento']): ?>
                        - <?= esc($imovel['complemento']) ?>
                    <?php endif; ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (!empty($fotos)): ?>
            <div class="card">
                <h2>📸 Fotos do Imóvel</h2>
                <div class="fotos-grid">
                    <?php foreach ($fotos as $foto): ?>
                        <div class="foto-item">
                            <img src="<?= esc($foto['caminho_completo']) ?>" alt="<?= esc($foto['nome_arquivo']) ?>">
                            <?php if ($foto['capa']): ?>
                                <span class="foto-capa-badge">Capa</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($imovel['descricao'])): ?>
            <div class="descricao-section">
                <h2>📝 Descrição</h2>
                <p><?= nl2br(esc($imovel['descricao'])) ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($imovel['caracteristicas'])): ?>
            <div class="card">
                <h2>✨ Características Especiais</h2>
                <ul class="caracteristicas-list">
                    <?php 
                    $caracteristicas = explode("\n", $imovel['caracteristicas']);
                    foreach ($caracteristicas as $caracteristica): 
                        $caracteristica = trim($caracteristica);
                        if (!empty($caracteristica)):
                    ?>
                        <li><?= esc($caracteristica) ?></li>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imobiliária - Imóveis Disponíveis</title>
    <?= $this->include('partials/header') ?>
    <style>
        .imoveis-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--spacing-md);
        }
        .imovel-card {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .imovel-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        .imovel-card.destaque {
            border: 2px solid var(--warning-color);
        }
        .imovel-imagem {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: var(--bg-secondary);
        }
        .imovel-conteudo {
            padding: var(--spacing-md);
        }
        .imovel-titulo {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: var(--spacing-sm);
        }
        .imovel-tipo,
        .imovel-localizacao {
            color: var(--text-secondary);
            font-size: 0.9375rem;
            margin-bottom: var(--spacing-xs);
        }
        .imovel-detalhes {
            display: flex;
            gap: var(--spacing-md);
            margin-bottom: var(--spacing-sm);
            font-size: 0.875rem;
            color: var(--text-secondary);
        }
        .imovel-preco {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--success-color);
            margin: var(--spacing-sm) 0;
        }
        .destaque-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: var(--warning-color);
            color: #78350f;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: var(--spacing-sm);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header text-center">
            <h1>Imóveis Disponíveis</h1>
        </div>

        <?php if (isset($imoveis) && !empty($imoveis)): ?>
            <div class="imoveis-grid">
                <?php foreach ($imoveis as $imovel): ?>
                    <a href="<?= site_url('imovel/' . $imovel['id']) ?>" class="imovel-card <?= $imovel['destaque'] ? 'destaque' : '' ?>">
                        <?php if ($imovel['foto_capa']): ?>
                            <img src="<?= esc($imovel['foto_capa']) ?>" alt="<?= esc($imovel['titulo']) ?>" class="imovel-imagem">
                        <?php else: ?>
                            <div class="imovel-imagem" style="display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                Sem foto
                            </div>
                        <?php endif; ?>
                        
                        <div class="imovel-conteudo">
                            <div class="imovel-titulo">
                                <?= esc($imovel['titulo']) ?>
                                <?php if ($imovel['destaque']): ?>
                                    <span class="destaque-badge">⭐ Destaque</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="imovel-tipo">
                                <strong>Tipo:</strong> <?= esc($imovel['tipo_imovel']) ?>
                            </div>
                            
                            <div class="imovel-localizacao">
                                <strong>Localização:</strong> <?= esc($imovel['bairro']) ?>
                            </div>
                            
                            <div class="imovel-detalhes">
                                <?php if ($imovel['dormitorios'] > 0): ?>
                                    <span>🛏️ <?= $imovel['dormitorios'] ?> quartos</span>
                                <?php endif; ?>
                                <?php if ($imovel['banheiros'] > 0): ?>
                                    <span>🚿 <?= $imovel['banheiros'] ?> banheiros</span>
                                <?php endif; ?>
                                <?php if ($imovel['garagem'] > 0): ?>
                                    <span>🚗 <?= $imovel['garagem'] ?> vagas</span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($imovel['area_total']): ?>
                                <div style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: var(--spacing-sm);">
                                    <strong>Área:</strong> <?= number_format($imovel['area_total'], 0, ',', '.') ?> m²
                                </div>
                            <?php endif; ?>
                            
                            <div class="imovel-preco">
                                <?php if (!empty($imovel['finalidade']) && $imovel['finalidade'] == 'venda' && $imovel['preco_venda']): ?>
                                    R$ <?= number_format($imovel['preco_venda'], 2, ',', '.') ?>
                                <?php elseif (!empty($imovel['finalidade']) && $imovel['finalidade'] == 'aluguel' && $imovel['preco_aluguel']): ?>
                                    R$ <?= number_format($imovel['preco_aluguel'], 2, ',', '.') ?>/mês
                                <?php elseif ($imovel['preco_venda']): ?>
                                    Venda: R$ <?= number_format($imovel['preco_venda'], 2, ',', '.') ?>
                                <?php elseif ($imovel['preco_aluguel']): ?>
                                    Aluguel: R$ <?= number_format($imovel['preco_aluguel'], 2, ',', '.') ?>/mês
                                <?php else: ?>
                                    Consulte
                                <?php endif; ?>
                            </div>
                            
                            <div>
                                <span class="badge badge-success"><?= esc(ucfirst($imovel['status'])) ?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card text-center">
                <p>Nenhum imóvel disponível no momento.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

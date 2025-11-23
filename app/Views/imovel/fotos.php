<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerir Fotos - <?= esc($imovel['titulo']) ?></title>
    <?= $this->include('partials/header') ?>
    <style>
        .fotos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: var(--spacing-md);
            margin-top: var(--spacing-md);
        }
        .foto-card {
            position: relative;
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .foto-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .capa-badge {
            position: absolute;
            top: var(--spacing-xs);
            left: var(--spacing-xs);
            background-color: var(--success-color);
            color: white;
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 600;
        }
        .foto-card .info {
            padding: var(--spacing-sm);
        }
        .foto-card .actions {
            display: flex;
            gap: var(--spacing-xs);
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Gerir Fotos do Imóvel</h1>
            <p><?= esc($imovel['titulo']) ?></p>
        </div>

        <?php if (session()->getFlashdata('sucesso')): ?>
            <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('erro')): ?>
            <div class="alert alert-error"><?= esc(session()->getFlashdata('erro')) ?></div>
        <?php endif; ?>

        <div class="card">
            <h2>Enviar Nova Foto</h2>
            <form action="<?= site_url('imovel/fotos/create/' . $imovel['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="foto">Selecione uma foto</label>
                    <input type="file" id="foto" name="foto" required>
                </div>

                <div class="actions-bar">
                    <button type="submit" class="btn btn-primary">Enviar Foto</button>
                </div>
            </form>
        </div>

        <div class="card">
            <h2>Fotos Atuais</h2>
            <?php if (empty($fotos)): ?>
                <p class="text-center">Nenhuma foto encontrada para este imóvel.</p>
            <?php else: ?>
                <div class="fotos-grid">
                    <?php foreach ($fotos as $foto): ?>
                        <div class="foto-card">
                            <img src="<?= base_url($foto['caminho']) ?>">
                            
                            <?php if ($foto['capa']): ?>
                                <span class="capa-badge">Capa</span>
                            <?php endif; ?>

                            <div class="info">
                                <div class="actions">
                                    <?php if (!$foto['capa']): ?>
                                        <a href="<?= site_url('imovel/fotos/update/' . $foto['id']) ?>" class="btn btn-secondary">Definir Capa</a>
                                    <?php endif; ?>
                                    <a href="<?= site_url('imovel/fotos/delete/' . $foto['id']) ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta foto?')">Excluir</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="actions-bar">
            <a href="<?= site_url('/imovel/listar') ?>" class="btn btn-secondary">← Voltar para a lista de imóveis</a>
        </div>
    </div>
</body>
</html>

<?php
    // $header, $imovel, e $fotos são passados pelo FotosImoveisController
    echo $header; 
?>

<!-- O bloco <style>...</style> foi removido -->

<div class="container">

    <h1>
        Gerir Fotos do Imóvel
        <br>
        <small><?= esc($imovel['titulo']) ?></small>
    </h1>

    <!-- Mensagens de Feedback -->
    <?php if (session()->getFlashdata('sucesso')): ?>
        <div class="alert alert-sucesso"><?= esc(session()->getFlashdata('sucesso')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('erro')): ?>
        <div class="alert alert-erro"><?= esc(session()->getFlashdata('erro')) ?></div>
    <?php endif; ?>

    <!-- 1. CÓDIGO PARA ENVIAR (UPLOAD) -->
    <div class="form-upload">
        <h2>Enviar Nova Foto</h2>
        
        <!-- O formulário aponta para a rota create/[id_do_imovel] -->
        <form action="<?= site_url('imovel/fotos/create/' . $imovel['id']) ?>" method="post" enctype="multipart/form-data">
            
            <?= csrf_field() ?>
            
            <input type="file" name="foto" required>
            <button type="submit">Enviar Foto</button>
        </form>
    </div>


    <!-- 2. CÓDIGO PARA LISTAR -->
    <h2>Fotos Atuais</h2>
    <div class="fotos-grid">
        
        <?php if (empty($fotos)): ?>
            <p>Nenhuma foto encontrada para este imóvel.</p>
        <?php else: ?>
            <?php foreach ($fotos as $foto): ?>
                <div class="foto-card">
                    
                    <img src="<?= base_url($foto['caminho']) ?>" alt="<?= esc($foto['nome_arquivo']) ?>" style="width: 100%; height: 150px; object-fit: cover;">
                    
                    <?php if ($foto['capa']): ?>
                        <div class="capa-badge" style="position: absolute; top: 10px; left: 10px; background: #28a745; color: white; padding: 5px; border-radius: 5px;">Capa</div>
                    <?php endif; ?>

                    <div class="info">
                        <div class="actions">
                            
                            <!-- Botão Definir Capa (Update) -->
                            <?php if (!$foto['capa']): ?>
                                <a href="<?= site_url('imovel/fotos/update/' . $foto['id']) ?>" class="btn-capa">Definir Capa</a>
                            <?php endif; ?>
                            
                            <!-- Botão Excluir (Delete) -->
                            <a href="<?= site_url('imovel/fotos/delete/' . $foto['id']) ?>" class="btn-excluir" onclick="return confirm('Tem a certeza que deseja excluir esta foto?')">Excluir</a>
                        
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
    
    <br>
    <a href="<?= site_url('/imovel/listar') ?>">Voltar para a lista de imóveis</a>

</div>


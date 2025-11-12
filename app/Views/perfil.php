<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container container-sm">
        <div class="page-header">
            <h1>Meu Perfil</h1>
        </div>

        <div class="card">
            <div class="info-grid">
                <div class="info-card">
                    <h3>ID</h3>
                    <p><?= esc($usuario['id']) ?></p>
                </div>

                <div class="info-card">
                    <h3>Nome</h3>
                    <p><?= esc($usuario['nome']) ?></p>
                </div>

                <div class="info-card">
                    <h3>Email</h3>
                    <p><?= esc($usuario['email']) ?></p>
                </div>

                <div class="info-card">
                    <h3>Tipo</h3>
                    <p>
                        <span class="badge <?= $usuario['tipo'] == 'admin' ? 'badge-primary' : 'badge-success' ?>">
                            <?= esc(ucfirst($usuario['tipo'])) ?>
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

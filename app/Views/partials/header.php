    <?php
        // Pega a sessão atual
        $session = session();
        $usuario_logado = $session->get('usuario_logado');
        $tipo_usuario = $session->get('tipo'); // Assumindo que você corrigiu o AuthController
        $nome_usuario = $session->get('nome');
    ?>

    <style>
        /* Estilo do Header Fixo */
        .main-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            z-index: 1000;
            display: flex;
            /* ALTERAÇÃO: Centraliza o conteúdo */
            justify-content: center; 
            align-items: center;
            padding: 0 20px;
            height: 60px; /* Altura do header */
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            font-family: Arial, sans-serif;
            gap: 30px; /* Espaçamento entre logo e nav */
        }

        .main-header .logo {
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
            color: #333;
        }

        .main-header nav ul {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            align-items: center;
        }

        .main-header nav li {
            margin-left: 20px;
        }

        .main-header nav a {
            text-decoration: none;
            color: #555;
            font-size: 1rem;
        }
        
        .main-header nav a.logout {
            color: #d9534f;
        }

        .main-header .user-info {
            color: #777;
        }

        /* * IMPORTANTE:
        * Adiciona um "espaçador" no topo do <body>
        * para que o seu conteúdo não comece *atrás* do header fixo.
        */
        body {
            padding-top: 60px; /* Deve ser igual à altura do .main-header */
        }
    </style>

    <header class="main-header">
        <a href="<?= site_url('/') ?>" class="logo">Imobiliária</a>

        <nav>
            <ul>
                <?php if ($usuario_logado): ?>
                    
                    <!-- Links para TODOS os usuários logados -->
                    <li><a href="<?= site_url('/imovel/listar') ?>">Meus Imóveis</a></li>
                    
                    <!-- Link do Perfil agora é o nome do usuário -->
                    <li><a href="<?= site_url('/perfil') ?>"><?= $usuario['nome'] ?></a></li>

                    <?php if ($usuario['tipo'] === 'admin'): ?>
                        <!-- Links exclusivos do ADMIN -->
                        <!-- ADICIONADO: Link do Dashboard -->
                        <li><a href="<?= site_url('/admin/dashboard') ?>">Dashboard</a></li>
                       
                    <?php endif; ?>
                    
                    <li><a href="<?= site_url('/logout') ?>" class="logout">Sair</a></li>
                
                <?php else: ?>
                    
                    <!-- Links para VISITANTES (não logados) -->
                    <li><a href="<?= site_url('/login') ?>">Login</a></li>
                
                <?php endif; ?>
            </ul>
        </nav>
    </header>


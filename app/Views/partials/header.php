<?php
    // Pega a sessão atual
    $session = session();
    $usuario_logado = $session->get('usuario_logado');
    $tipo_usuario = $session->get('tipo');
    $nome_usuario = $session->get('nome');
?>

<style>
    /* ============================================
       MINIMALIST CSS FRAMEWORK - STANDARDIZED
       ============================================ */
    
    /* Reset & Base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary-color: #2563eb;
        --primary-hover: #1d4ed8;
        --secondary-color: #64748b;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-hover: #f1f5f9;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --radius-sm: 4px;
        --radius-md: 8px;
        --radius-lg: 12px;
        --spacing-xs: 0.5rem;
        --spacing-sm: 1rem;
        --spacing-md: 1.5rem;
        --spacing-lg: 2rem;
        --spacing-xl: 3rem;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        font-size: 16px;
        line-height: 1.6;
        color: var(--text-primary);
        background-color: var(--bg-secondary);
        padding-top: 70px;
    }

    /* Typography */
    h1, h2, h3, h4, h5, h6 {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: var(--spacing-md);
    }

    h1 { font-size: 2rem; }
    h2 { font-size: 1.5rem; }
    h3 { font-size: 1.25rem; }
    h4 { font-size: 1.125rem; }

    p {
        margin-bottom: var(--spacing-sm);
        color: var(--text-secondary);
    }

    a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    a:hover {
        color: var(--primary-hover);
    }

    /* Header */
    .main-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: var(--bg-primary);
        border-bottom: 1px solid var(--border-color);
        z-index: 1000;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0 var(--spacing-md);
        height: 70px;
        box-shadow: var(--shadow-sm);
        gap: var(--spacing-xl);
    }

    .main-header .logo {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .main-header nav ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
    }

    .main-header nav a {
        color: var(--text-secondary);
        font-size: 0.9375rem;
        padding: var(--spacing-xs) var(--spacing-sm);
        border-radius: var(--radius-sm);
        transition: all 0.2s ease;
    }

    .main-header nav a:hover {
        color: var(--primary-color);
        background-color: var(--bg-hover);
    }

    .main-header nav a.logout {
        color: var(--danger-color);
    }

    .main-header nav a.logout:hover {
        background-color: #fee2e2;
    }

    /* Container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: var(--spacing-lg);
    }

    .container-sm {
        max-width: 800px;
        margin: 0 auto;
        padding: var(--spacing-lg);
    }

    /* Cards */
    .card {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: var(--spacing-md);
        box-shadow: var(--shadow-sm);
        transition: box-shadow 0.2s ease;
    }

    .card:hover {
        box-shadow: var(--shadow-md);
    }

    /* Buttons */
    .btn {
        display: inline-block;
        padding: var(--spacing-xs) var(--spacing-md);
        border: 1px solid transparent;
        border-radius: var(--radius-sm);
        font-size: 0.9375rem;
        font-weight: 500;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
        color: white;
    }

    .btn-secondary {
        background-color: var(--bg-primary);
        color: var(--text-primary);
        border-color: var(--border-color);
    }

    .btn-secondary:hover {
        background-color: var(--bg-hover);
    }

    .btn-danger {
        background-color: var(--danger-color);
        color: white;
        border-color: var(--danger-color);
    }

    .btn-danger:hover {
        background-color: #dc2626;
    }

    .btn-success {
        background-color: var(--success-color);
        color: white;
        border-color: var(--success-color);
    }

    /* Forms */
    .form-group {
        margin-bottom: var(--spacing-md);
    }

    label {
        display: block;
        margin-bottom: var(--spacing-xs);
        font-weight: 500;
        color: var(--text-primary);
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    input[type="date"],
    select,
    textarea {
        width: 100%;
        padding: var(--spacing-xs) var(--spacing-sm);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        font-size: 0.9375rem;
        font-family: inherit;
        color: var(--text-primary);
        background-color: var(--bg-primary);
        transition: border-color 0.2s ease;
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    /* Tables */
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: var(--bg-primary);
        border-radius: var(--radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    thead {
        background-color: var(--bg-secondary);
    }

    th {
        padding: var(--spacing-sm);
        text-align: left;
        font-weight: 600;
        color: var(--text-primary);
        border-bottom: 2px solid var(--border-color);
    }

    td {
        padding: var(--spacing-sm);
        border-bottom: 1px solid var(--border-color);
        color: var(--text-secondary);
    }

    tr:hover {
        background-color: var(--bg-hover);
    }

    /* Alerts */
    .alert {
        padding: var(--spacing-sm) var(--spacing-md);
        border-radius: var(--radius-sm);
        margin-bottom: var(--spacing-md);
        border-left: 4px solid;
    }

    .alert-success {
        background-color: #d1fae5;
        border-color: var(--success-color);
        color: #065f46;
    }

    .alert-error {
        background-color: #fee2e2;
        border-color: var(--danger-color);
        color: #991b1b;
    }

    .alert-warning {
        background-color: #fef3c7;
        border-color: var(--warning-color);
        color: #92400e;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .badge-success {
        background-color: #d1fae5;
        color: #065f46;
    }

    .badge-danger {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .badge-warning {
        background-color: #fef3c7;
        color: #92400e;
    }

    .badge-primary {
        background-color: #dbeafe;
        color: #1e40af;
    }

    /* Grid */
    .grid {
        display: grid;
        gap: var(--spacing-md);
    }

    .grid-2 {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    .grid-3 {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }

    .grid-4 {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }

    /* Utilities */
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .mt-sm { margin-top: var(--spacing-sm); }
    .mt-md { margin-top: var(--spacing-md); }
    .mt-lg { margin-top: var(--spacing-lg); }
    .mb-sm { margin-bottom: var(--spacing-sm); }
    .mb-md { margin-bottom: var(--spacing-md); }
    .mb-lg { margin-bottom: var(--spacing-lg); }
    .p-sm { padding: var(--spacing-sm); }
    .p-md { padding: var(--spacing-md); }
    .p-lg { padding: var(--spacing-lg); }

    /* Page Header */
    .page-header {
        margin-bottom: var(--spacing-xl);
        padding-bottom: var(--spacing-md);
        border-bottom: 1px solid var(--border-color);
    }

    .page-header h1 {
        margin-bottom: var(--spacing-xs);
    }

    /* Actions Bar */
    .actions-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-md);
        flex-wrap: wrap;
        gap: var(--spacing-sm);
    }

    /* Form Buttons */
    button[type="submit"],
    button.btn {
        border: none;
        cursor: pointer;
    }

    /* Checkbox and Radio */
    input[type="checkbox"],
    input[type="radio"] {
        width: auto;
        margin-right: var(--spacing-xs);
    }

    /* Links in tables */
    table a {
        margin-right: var(--spacing-xs);
    }
</style>

<header class="main-header">
    <a href="<?= site_url('/') ?>" class="logo">Imobiliária</a>

    <nav>
        <ul>
            <?php if ($usuario_logado): ?>
                <li><a href="<?= site_url('/imovel/listar') ?>">Meus Imóveis</a></li>
                <li><a href="<?= site_url('/perfil') ?>">Meu Perfil</a></li>
                <?php if ($tipo_usuario == 'admin'): ?>
                    <li><a href="<?= site_url('/admin/dashboard') ?>">Dashboard</a></li>
                <?php endif; ?>
                <li><a href="<?= site_url('/logout') ?>" class="logout">Sair</a></li>
            <?php else: ?>
                <li><a href="<?= site_url('/login') ?>">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

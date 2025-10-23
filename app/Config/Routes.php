<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// --- Rotas Públicas (Login, Perfil) ---
$routes->get('/paginainicial', 'Home::index');
$routes->get('/login', 'AuthController::mostrarTelaLogin');
$routes->post('/processarLogin', 'AuthController::processarLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/perfil', 'SiteController::meuPerfil');


// --- Grupo de Rotas ADMIN ---
// Agrupa todas as rotas de admin sob o filtro 'admin'
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {

    /**
     * Dashboard (Página inicial do Admin)
     * Rota: GET /admin/dashboard
     * Mapeia para: AdminController::index()
     */
    $routes->get('dashboard', 'AdminController::index');

    /**
     * (R) READ - Lista TODOS os usuários
     * Rota: GET /admin/listar
     * Mapeia para: AdminController::listarUsuarios()
     */
    $routes->get('listar', 'AdminController::listarUsuarios');

    /**
     * (C) CREATE - Mostra formulário de Corretor
     * Rota: GET /admin/formulariocorretor
     * Mapeia para: AdminController::create()
     */
    $routes->get('formulariocorretor', 'AdminController::create');

    /**
     * (C) STORE - Salva o novo Corretor
     * Rota: POST /admin/store
     * Mapeia para: AdminController::store()
     */
    $routes->post('store', 'AdminController::store');

    /**
     * (U) EDIT - Mostra formulário de edição de Corretor
     * Rota: GET /admin/edit/[ID]
     * Mapeia para: AdminController::edit($id)
     */
    $routes->get('edit/(:num)', 'AdminController::edit/$1');

    /**
     * (U) UPDATE - Salva as alterações do Corretor
     * Rota: POST /admin/update/[ID]
     * Mapeia para: AdminController::update($id)
     */
    $routes->post('update/(:num)', 'AdminController::update/$1');

    /**
     * (D) DELETE - Exclui o Corretor
     * Rota: GET /admin/delete/[ID]
     * Mapeia para: AdminController::delete($id)
     */
    $routes->get('delete/(:num)', 'AdminController::delete/$1');

    
    // --- CRUD TIPOS DE IMÓVEIS ---
    // Rotas: /admin/tipoimoveis/listar, /admin/tipoimoveis/criar, etc.
    $routes->group('tipoimoveis', static function ($routes) {
        $routes->get('listar', 'TipoImovelController::index');
        $routes->get('criar', 'TipoImovelController::create');
        $routes->post('salvar', 'TipoImovelController::store');
        $routes->get('editar/(:num)', 'TipoImovelController::edit/$1');
        $routes->post('atualizar/(:num)', 'TipoImovelController::update/$1');
        $routes->get('excluir/(:num)', 'TipoImovelController::delete/$1');
    });

    // --- CRUD BAIRROS ---
    // Rotas: /admin/bairro/listar, /admin/bairro/criar, etc.
    $routes->group('bairro', static function ($routes) {
        $routes->get('listar', 'BairroController::index');
        $routes->get('criar', 'BairroController::create');
        $routes->post('salvar', 'BairroController::store');
        $routes->get('editar/(:num)', 'BairroController::edit/$1');
        $routes->post('atualizar/(:num)', 'BairroController::update/$1');
        $routes->get('excluir/(:num)', 'BairroController::delete/$1');
    });

});


// --- GRUPO DE ROTAS DE IMÓVEIS (CRUD COMPLETO) ---
// O próprio ImovelController já verifica se o usuário está logado
$routes->group('imovel', static function ($routes) {
    /**
     * (R) READ
     * Rota: GET /imovel/listar
     * Mapeia para: ImovelController::index()
     */
    $routes->get('listar', 'ImovelController::index');

    /**
     * (C) CREATE
     * Rota: GET /imovel/cadastrar
     * Mapeia para: ImovelController::create()
     */
    $routes->get('cadastrar', 'ImovelController::create');

    /**
     * (C) STORE
     * Rota: POST /imovel/salvar
     * Mapeia para: ImovelController::store()
     */
    $routes->post('salvar', 'ImovelController::store');

    /**
     * (U) EDIT
     * Rota: GET /imovel/editar/[ID]
     * Mapeia para: ImMovelController::edit($id)
     */
    $routes->get('editar/(:num)', 'ImMovelController::edit/$1');

    /**
     * (U) UPDATE
     * Rota: POST /imovel/atualizar/[ID]
     * Mapeia para: ImovelController::update($id)
     */
    $routes->post('atualizar/(:num)', 'ImovelController::update/$1');

    /**
     * (D) DELETE   
     * Rota: GET /imovel/excluir/[ID]
     * Mapeia para: ImovelController::delete($id)
     */
    $routes->get('excluir/(:num)', 'ImovelController::delete/$1');
});


<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// --- Rotas Públicas (Login, Perfil) ---
$routes->get('/paginainicial', 'Home::index');
$routes->get('/imovel/(:num)', 'Home::show/$1'); // Rota pública para ver detalhes do imóvel
$routes->get('/login', 'AuthController::mostrarTelaLogin');
$routes->post('/processarLogin', 'AuthController::processarLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/perfil', 'SiteController::meuPerfil');


// --- Grupo de Rotas ADMIN ---
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {

    $routes->get('dashboard', 'AdminController::index');

    $routes->get('listar', 'AdminController::listarUsuarios');
    $routes->get('formulariocorretor', 'AdminController::create');
    $routes->post('store', 'AdminController::store');
    $routes->get('edit/(:num)', 'AdminController::edit/$1');
    $routes->post('update/(:num)', 'AdminController::update/$1');
    $routes->get('delete/(:num)', 'AdminController::delete/$1');

    
    $routes->group('tipoimoveis', static function ($routes) {
        $routes->get('listar', 'TipoImovelController::index');
        $routes->get('criar', 'TipoImovelController::create');
        $routes->post('salvar', 'TipoImovelController::store');
        $routes->get('editar/(:num)', 'TipoImovelController::edit/$1');
        $routes->post('atualizar/(:num)', 'TipoImovelController::update/$1');
        $routes->get('excluir/(:num)', 'TipoImovelController::delete/$1');
    });

    $routes->group('bairro', static function ($routes) {
        $routes->get('listar', 'BairroController::index');
        $routes->get('criar', 'BairroController::create');
        $routes->post('salvar', 'BairroController::store');
        $routes->get('editar/(:num)', 'BairroController::edit/$1');
        $routes->post('atualizar/(:num)', 'BairroController::update/$1');
        $routes->get('excluir/(:num)', 'BairroController::delete/$1');
    });

});


$routes->group('imovel', ['filter' => 'session'], static function ($routes) {
    
    // Rotas do Imovel
    $routes->get('listar', 'ImovelController::index');
    $routes->get('cadastrar', 'ImovelController::create');
    $routes->post('salvar', 'ImovelController::store');
    $routes->get('editar/(:num)', 'ImovelController::edit/$1');
    $routes->post('update/(:num)', 'ImovelController::update/$1');
    $routes->get('excluir/(:num)', 'ImovelController::delete/$1');


    // Rotas das Fotos (Corrigido)
    // Agora vai criar: /imovel/fotos/listar/1, etc.
    $routes->group('fotos', static function ($routes) {
        $routes->get('read/(:num)', 'FotosImoveisController::read/$1'); 
        $routes->post('create/(:num)', 'FotosImoveisController::create/$1');
        $routes->get('update/(:num)', 'FotosImoveisController::update/$1');
        $routes->get('delete/(:num)', 'FotosImoveisController::delete/$1');
    });
});

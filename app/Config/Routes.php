<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//login e logout
$routes->get('/paginainicial', 'SiteController::PaginaInicial');
$routes->get('/login', 'AuthController::mostrarTelaLogin');
$routes->post('/processarLogin', 'AuthController::processarLogin');
$routes->get('/dashboard', 'SiteController::dashboard', ['filter' => 'admin']);
$routes->get('/logout', 'AuthController::logout');
$routes->get('/cadastrarcorretor', 'CorretorController::CadastrarCorretorFormulario');
$routes->post('/cadastrarCorretor', 'CorretorController::cadastrarCorretor');
$routes->get('/perfil', 'SiteController::meuPerfil');
$routes->get('/cadastrarimovel', 'ImovelController::index');
$routes->post('/registrarimovel', 'ImovelController::registrarImovel');
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
//login e logout
$routes->get('/login', 'AuthController::mostrarTelaLogin');
$routes->post('/processarLogin', 'AuthController::processarLogin');
$routes->get('/logout', 'AuthController::logout');

//rota para gerar senha (apenas para teste, remover depois)
$routes->get('/gerarsenha', 'AuthController::gerarSenha');  
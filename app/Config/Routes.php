<?php

use App\Controllers\AuthController;
use App\Controllers\Home;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('', ['filter' => 'AuthCheck'], function (RouteCollection $routes) {
    $routes->get('/', [Home::class, 'index']);
    $routes->get('seferler', [Home::class, 'seferler']);
});

$routes->get('logout', [AuthController::class, 'logout']);
$routes->post('save', [AuthController::class, 'save']);
$routes->post('check', [AuthController::class, 'check']);
$routes->post('seferAra', [Home::class, 'seferAra']);

$routes->group('', ['filter' => 'AlreadyLoggedIn'], function (RouteCollection $routes) {
    $routes->get('login', [AuthController::class, 'login']);
    $routes->get('register', [AuthController::class, 'register']);
});
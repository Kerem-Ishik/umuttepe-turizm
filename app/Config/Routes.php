<?php

use App\Controllers\AuthController;
use App\Controllers\Home;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('', ['filter' => 'AuthCheck'], function (RouteCollection $routes) {
    $routes->get('/', [Home::class, 'index']);
});

$routes->group('', ['filter' => 'AlreadyLoggedIn'], function (RouteCollection $routes) {
    $routes->get('login', [AuthController::class, 'login']);
    $routes->get('register', [AuthController::class, 'register']);
    $routes->post('save', [AuthController::class, 'save']);
    $routes->post('check', [AuthController::class, 'check']);
    $routes->get('logout', [AuthController::class, 'logout']);
});
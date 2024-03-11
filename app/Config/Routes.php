<?php

use App\Controllers\AuthController;
use App\Controllers\Home;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);
$routes->get('login', [AuthController::class, 'login']);
$routes->get('register', [AuthController::class, 'register']);
$routes->post('save', [AuthController::class, 'save']);
$routes->post('check', [AuthController::class, 'check']);
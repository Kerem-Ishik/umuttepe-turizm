<?php

use App\Controllers\AuthController;
use App\Controllers\Home;
use App\Controllers\KoltukController;
use App\Controllers\OdemeController;
use App\Controllers\SeferController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('', ['filter' => 'AuthCheck'], function (RouteCollection $routes) {
    $routes->get('/', [Home::class, 'index']);
    $routes->get('seferler', [SeferController::class, 'index']);
    $routes->get('koltuk-secimi', [KoltukController::class, 'index']);
    $routes->get('odeme', [OdemeController::class, 'index']);
    $routes->get('onay', [OdemeController::class, 'onay']);
    $routes->get('profile', [AuthController::class, 'profile']);
    $routes->get('profile/biletler', [AuthController::class, 'biletler']);
});

$routes->get('logout', [AuthController::class, 'logout']);
$routes->post('save', [AuthController::class, 'save']);
$routes->post('check', [AuthController::class, 'check']);
$routes->post('update', [AuthController::class, 'update']);
$routes->post('seferAra', [SeferController::class, 'seferAra']);
$routes->post('koltukSecimi', [KoltukController::class, 'koltukSecimi']);
$routes->post('odemeAl', [OdemeController::class, 'odemeAl']);
$routes->post('odemeKontrol', [OdemeController::class, 'odemeKontrol']);
$routes->delete('bilet-sil/(:num)', [AuthController::class, 'biletSil']);
$routes->get('bilet-kontrol/(:segment)', [AuthController::class, 'biletKontrol']);

$routes->group('', ['filter' => 'AlreadyLoggedIn'], function (RouteCollection $routes) {
    $routes->get('login', [AuthController::class, 'login']);
    $routes->get('register', [AuthController::class, 'register']);
});
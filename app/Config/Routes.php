<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('testenv', 'Testenv::index');

$routes->get('/', 'clogin::index');

$routes->get('login', 'clogin::index');
$routes->post('clogeo', 'clogin::clogeo');
$routes->get('logout', 'clogin::clogout');

$routes->get('dashboard', 'Home::index');

$routes->group('', ['filter' => 'auth'], function($routes){
    $routes->get('dashboard', 'Home::index');
    // aquí metes todas las rutas privadas:
    // $routes->get('productos', 'Producto::index');
    // $routes->get('ventas', 'Venta::index');
});

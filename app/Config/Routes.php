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
    $routes->get('categoria', 'mantenimiento\ccategoria::index');
$routes->get('categoria/add', 'mantenimiento\ccategoria::add');
$routes->post('categoria/store', 'mantenimiento\ccategoria::store');
$routes->get('categoria/edit/(:num)', 'mantenimiento\ccategoria::edit/$1');
$routes->post('categoria/update/(:num)', 'mantenimiento\ccategoria::update/$1');
$routes->get('categoria/delete/(:num)', 'mantenimiento\ccategoria::delete/$1');

});

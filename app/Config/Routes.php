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

$routes->group('', ['filter' => 'auth'], function($routes){

    $routes->get('dashboard', 'Home::index');

    // TODO MANTENIMIENTO
    $routes->group('mantenimiento', function($routes){

        // categoria
        $routes->get('categoria', 'mantenimiento\ccategoria::index');
        $routes->get('categoria/add', 'mantenimiento\ccategoria::add');
        $routes->post('categoria/store', 'mantenimiento\ccategoria::store');
        $routes->get('categoria/edit/(:num)', 'mantenimiento\ccategoria::edit/$1');
        $routes->post('categoria/update/(:num)', 'mantenimiento\ccategoria::update/$1');
        $routes->get('categoria/view/(:num)', 'mantenimiento\ccategoria::view/$1');
        $routes->get('categoria/delete/(:num)', 'mantenimiento\ccategoria::delete/$1');

        // tipo_documento
        $routes->get('tipo_documento', 'mantenimiento\ctipo_documento::index');
        $routes->get('tipo_documento/add', 'mantenimiento\ctipo_documento::add');
        $routes->post('tipo_documento/store', 'mantenimiento\ctipo_documento::store');
        $routes->get('tipo_documento/edit/(:num)', 'mantenimiento\ctipo_documento::edit/$1');
        $routes->post('tipo_documento/update/(:num)', 'mantenimiento\ctipo_documento::update/$1');
        $routes->get('tipo_documento/view/(:num)', 'mantenimiento\ctipo_documento::view/$1');
        $routes->get('tipo_documento/delete/(:num)', 'mantenimiento\ctipo_documento::delete/$1');

        $routes->group('', ['filter' => 'auth'], function($routes){

  $routes->group('movimientos', function($routes){

    // imprimir (html)
    $routes->get('boleta/(:num)', 'movimientos\cdocumento::boleta/$1');
    $routes->get('factura/(:num)', 'movimientos\cdocumento::factura/$1');

    // pdf
    $routes->get('boleta_pdf/(:num)', 'movimientos\cdocumento::boleta_pdf/$1');
    $routes->get('factura_pdf/(:num)', 'movimientos\cdocumento::factura_pdf/$1');

  });

});
    
    });

});

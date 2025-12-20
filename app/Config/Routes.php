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
    // ===== MANTENIMIENTO: COLOR =====
$routes->get('mantenimiento/color', 'mantenimiento\ccolor::index');
$routes->get('mantenimiento/color/add', 'mantenimiento\ccolor::add');
$routes->post('mantenimiento/color/store', 'mantenimiento\ccolor::store');
$routes->get('mantenimiento/color/edit/(:num)', 'mantenimiento\ccolor::edit/$1');
$routes->post('mantenimiento/color/update/(:num)', 'mantenimiento\ccolor::update/$1');
$routes->get('mantenimiento/color/view/(:num)', 'mantenimiento\ccolor::view/$1');
$routes->get('mantenimiento/color/delete/(:num)', 'mantenimiento\ccolor::delete/$1');

// ===== MANTENIMIENTO: MARCA =====
$routes->get('mantenimiento/marca', 'mantenimiento\cmarca::index');
$routes->get('mantenimiento/marca/add', 'mantenimiento\cmarca::add');
$routes->post('mantenimiento/marca/store', 'mantenimiento\cmarca::store');
$routes->get('mantenimiento/marca/edit/(:num)', 'mantenimiento\cmarca::edit/$1');
$routes->post('mantenimiento/marca/update/(:num)', 'mantenimiento\cmarca::update/$1');
$routes->get('mantenimiento/marca/view/(:num)', 'mantenimiento\cmarca::view/$1');
$routes->get('mantenimiento/marca/delete/(:num)', 'mantenimiento\cmarca::delete/$1');

// ===== MANTENIMIENTO: TIPO MATERIAL =====
$routes->get('mantenimiento/tipo_material', 'mantenimiento\ctipo_material::index');
$routes->get('mantenimiento/tipo_material/add', 'mantenimiento\ctipo_material::add');
$routes->post('mantenimiento/tipo_material/store', 'mantenimiento\ctipo_material::store');
$routes->get('mantenimiento/tipo_material/edit/(:num)', 'mantenimiento\ctipo_material::edit/$1');
$routes->post('mantenimiento/tipo_material/update/(:num)', 'mantenimiento\ctipo_material::update/$1');
$routes->get('mantenimiento/tipo_material/view/(:num)', 'mantenimiento\ctipo_material::view/$1');
$routes->get('mantenimiento/tipo_material/delete/(:num)', 'mantenimiento\ctipo_material::delete/$1');

$routes->get('mantenimiento/unmedida', 'mantenimiento\cunmedida::index');
$routes->get('mantenimiento/unmedida/add', 'mantenimiento\cunmedida::add');
$routes->post('mantenimiento/unmedida/store', 'mantenimiento\cunmedida::store');
$routes->get('mantenimiento/unmedida/edit/(:num)', 'mantenimiento\cunmedida::edit/$1');
$routes->post('mantenimiento/unmedida/update/(:num)', 'mantenimiento\cunmedida::update/$1');
$routes->get('mantenimiento/unmedida/view/(:num)', 'mantenimiento\cunmedida::view/$1');
$routes->get('mantenimiento/unmedida/delete/(:num)', 'mantenimiento\cunmedida::delete/$1');


// ===== MANTENIMIENTO: TIPO CLIENTE =====
$routes->get('mantenimiento/tipo_cliente', 'mantenimiento\ctipo_cliente::index');
$routes->get('mantenimiento/tipo_cliente/add', 'mantenimiento\ctipo_cliente::add');
$routes->post('mantenimiento/tipo_cliente/store', 'mantenimiento\ctipo_cliente::store');
$routes->get('mantenimiento/tipo_cliente/edit/(:num)', 'mantenimiento\ctipo_cliente::edit/$1');
$routes->post('mantenimiento/tipo_cliente/update/(:num)', 'mantenimiento\ctipo_cliente::update/$1');
$routes->get('mantenimiento/tipo_cliente/view/(:num)', 'mantenimiento\ctipo_cliente::view/$1');
$routes->get('mantenimiento/tipo_cliente/delete/(:num)', 'mantenimiento\ctipo_cliente::delete/$1');


});

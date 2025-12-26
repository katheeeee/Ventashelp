<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =====================================================
// RUTAS PÚBLICAS
// =====================================================
$routes->get('/', 'clogin::index');
$routes->get('login', 'clogin::index');
$routes->post('clogeo', 'clogin::clogeo');
$routes->get('logout', 'clogin::clogout');

// =====================================================
// RUTAS PROTEGIDAS (AUTH)
// =====================================================
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // -------------------------
    // DASHBOARD
    // -------------------------
    $routes->get('dashboard', 'Home::index');

    // =================================================
    // MANTENIMIENTO
    // =================================================
    $routes->group('mantenimiento', function ($routes) {

        $routes->get('categoria', 'mantenimiento\ccategoria::index');
        $routes->get('categoria/add', 'mantenimiento\ccategoria::add');
        $routes->post('categoria/store', 'mantenimiento\ccategoria::store');
        $routes->get('categoria/edit/(:num)', 'mantenimiento\ccategoria::edit/$1');
        $routes->post('categoria/update/(:num)', 'mantenimiento\ccategoria::update/$1');
        $routes->get('categoria/view/(:num)', 'mantenimiento\ccategoria::view/$1');
        $routes->get('categoria/delete/(:num)', 'mantenimiento\ccategoria::delete/$1');

        $routes->get('tipo_documento', 'mantenimiento\ctipo_documento::index');
        $routes->get('tipo_documento/add', 'mantenimiento\ctipo_documento::add');
        $routes->post('tipo_documento/store', 'mantenimiento\ctipo_documento::store');
        $routes->get('tipo_documento/edit/(:num)', 'mantenimiento\ctipo_documento::edit/$1');
        $routes->post('tipo_documento/update/(:num)', 'mantenimiento\ctipo_documento::update/$1');
        $routes->get('tipo_documento/view/(:num)', 'mantenimiento\ctipo_documento::view/$1');
        $routes->get('tipo_documento/delete/(:num)', 'mantenimiento\ctipo_documento::delete/$1');

        $routes->get('color', 'mantenimiento\ccolor::index');
        $routes->get('color/add', 'mantenimiento\ccolor::add');
        $routes->post('color/store', 'mantenimiento\ccolor::store');
        $routes->get('color/edit/(:num)', 'mantenimiento\ccolor::edit/$1');
        $routes->post('color/update/(:num)', 'mantenimiento\ccolor::update/$1');
        $routes->get('color/view/(:num)', 'mantenimiento\ccolor::view/$1');
        $routes->get('color/delete/(:num)', 'mantenimiento\ccolor::delete/$1');

        $routes->get('marca', 'mantenimiento\cmarca::index');
        $routes->get('marca/add', 'mantenimiento\cmarca::add');
        $routes->post('marca/store', 'mantenimiento\cmarca::store');
        $routes->get('marca/edit/(:num)', 'mantenimiento\cmarca::edit/$1');
        $routes->post('marca/update/(:num)', 'mantenimiento\cmarca::update/$1');
        $routes->get('marca/view/(:num)', 'mantenimiento\cmarca::view/$1');
        $routes->get('marca/delete/(:num)', 'mantenimiento\cmarca::delete/$1');

        $routes->get('tipo_material', 'mantenimiento\ctipo_material::index');
        $routes->get('tipo_material/add', 'mantenimiento\ctipo_material::add');
        $routes->post('tipo_material/store', 'mantenimiento\ctipo_material::store');
        $routes->get('tipo_material/edit/(:num)', 'mantenimiento\ctipo_material::edit/$1');
        $routes->post('tipo_material/update/(:num)', 'mantenimiento\ctipo_material::update/$1');
        $routes->get('tipo_material/view/(:num)', 'mantenimiento\ctipo_material::view/$1');
        $routes->get('tipo_material/delete/(:num)', 'mantenimiento\ctipo_material::delete/$1');

        $routes->get('unmedida', 'mantenimiento\cunmedida::index');
        $routes->get('unmedida/add', 'mantenimiento\cunmedida::add');
        $routes->post('unmedida/store', 'mantenimiento\cunmedida::store');
        $routes->get('unmedida/edit/(:num)', 'mantenimiento\cunmedida::edit/$1');
        $routes->post('unmedida/update/(:num)', 'mantenimiento\cunmedida::update/$1');
        $routes->get('unmedida/view/(:num)', 'mantenimiento\cunmedida::view/$1');
        $routes->get('unmedida/delete/(:num)', 'mantenimiento\cunmedida::delete/$1');

        $routes->get('tipo_cliente', 'mantenimiento\ctipo_cliente::index');
        $routes->get('tipo_cliente/add', 'mantenimiento\ctipo_cliente::add');
        $routes->post('tipo_cliente/store', 'mantenimiento\ctipo_cliente::store');
        $routes->get('tipo_cliente/edit/(:num)', 'mantenimiento\ctipo_cliente::edit/$1');
        $routes->post('tipo_cliente/update/(:num)', 'mantenimiento\ctipo_cliente::update/$1');
        $routes->get('tipo_cliente/view/(:num)', 'mantenimiento\ctipo_cliente::view/$1');
        $routes->get('tipo_cliente/delete/(:num)', 'mantenimiento\ctipo_cliente::delete/$1');

        $routes->get('cliente', 'mantenimiento\ccliente::index');
        $routes->get('cliente/add', 'mantenimiento\ccliente::add');
        $routes->post('cliente/store', 'mantenimiento\ccliente::store');
        $routes->get('cliente/edit/(:num)', 'mantenimiento\ccliente::edit/$1');
        $routes->post('cliente/update/(:num)', 'mantenimiento\ccliente::update/$1');
        $routes->get('cliente/view/(:num)', 'mantenimiento\ccliente::view/$1');
        $routes->get('cliente/delete/(:num)', 'mantenimiento\ccliente::delete/$1');

        $routes->get('proveedor', 'mantenimiento\cproveedor::index');
        $routes->get('proveedor/add', 'mantenimiento\cproveedor::add');
        $routes->post('proveedor/store', 'mantenimiento\cproveedor::store');
        $routes->get('proveedor/edit/(:num)', 'mantenimiento\cproveedor::edit/$1');
        $routes->post('proveedor/update/(:num)', 'mantenimiento\cproveedor::update/$1');
        $routes->get('proveedor/view/(:num)', 'mantenimiento\cproveedor::view/$1');
        $routes->get('proveedor/delete/(:num)', 'mantenimiento\cproveedor::delete/$1');

        $routes->get('producto', 'mantenimiento\cproducto::index');
        $routes->get('producto/add', 'mantenimiento\cproducto::add');
        $routes->post('producto/store', 'mantenimiento\cproducto::store');
        $routes->get('producto/edit/(:num)', 'mantenimiento\cproducto::edit/$1');
        $routes->post('producto/update/(:num)', 'mantenimiento\cproducto::update/$1');
        $routes->get('producto/view/(:num)', 'mantenimiento\cproducto::view/$1');
        $routes->get('producto/delete/(:num)', 'mantenimiento\cproducto::delete/$1');
    });

    // =================================================
    // VENTAS
    // =================================================
    $routes->group('ventas', function ($routes) {

        $routes->get('/', 'ventas\cventa::index');
        $routes->get('add', 'ventas\cventa::add');
        $routes->post('store', 'ventas\cventa::store');
        $routes->get('view/(:num)', 'ventas\cventa::view/$1');

        // AJAX
        $routes->get('ajaxClientes', 'ventas\cventa::ajaxClientes');
        $routes->get('ajaxProductos', 'ventas\cventa::ajaxProductos');
        $routes->get('ajaxComprobanteData/(:num)', 'ventas\cventa::ajaxComprobanteData/$1');

        // PDF
        $routes->get('pdf/(:num)', 'ventas\cventa::pdf/$1');
    });

    // =================================================
    // REPORTES ✅ (FUERA de ventas)
    // =================================================
    $routes->group('reportes', function ($routes) {

        // vistas
        $routes->get('/', 'reportes\creportes::resumen');
        $routes->get('ventas_diarias', 'reportes\creportes::ventas_diarias');
        $routes->get('top_productos', 'reportes\creportes::top_productos');
        $routes->get('top_clientes', 'reportes\creportes::top_clientes');

        // data (json)
        $routes->get('resumen_data', 'reportes\creportesdata::resumen_data'); // ✅ NUEVA RUTA
        $routes->get('ventas_diarias_data', 'reportes\creportesdata::ventas_diarias_data');
        $routes->get('top_productos_data', 'reportes\creportesdata::top_productos_data');
        $routes->get('top_clientes_data', 'reportes\creportesdata::top_clientes_data');

        // export (csv "excel")
        $routes->get('export/ventas_diarias', 'reportes\cexportar::ventas_diarias');
        $routes->get('export/top_productos', 'reportes\cexportar::top_productos');
        $routes->get('export/top_clientes', 'reportes\cexportar::top_clientes');
    });

    // =================================================
    // ADMIN ✅ (FUERA de ventas)
    // =================================================
    $routes->group('admin', function ($routes) {

        // cambiar contraseña
        $routes->get('cambiar_password', 'admin\cadmin::cambiar_password');
        $routes->post('cambiar_password', 'admin\cadmin::guardar_password');

        // usuarios
        $routes->get('usuarios', 'admin\cusuarios::index');
        $routes->get('usuarios/add', 'admin\cusuarios::add');
        $routes->post('usuarios/store', 'admin\cusuarios::store');
        $routes->get('usuarios/edit/(:num)', 'admin\cusuarios::edit/$1');
        $routes->post('usuarios/update/(:num)', 'admin\cusuarios::update/$1');
        $routes->get('usuarios/toggle/(:num)', 'admin\cusuarios::toggle/$1');
    });
});

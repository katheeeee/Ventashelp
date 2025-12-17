<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('testenv', 'Testenv::index');

$routes->get('/', 'Clogin::index');

$routes->get('login', 'Clogin::index');
$routes->post('clogeo', 'Clogin::clogeo');
$routes->get('logout', 'Clogin::clogout');

$routes->get('dashboard', 'Home::index');



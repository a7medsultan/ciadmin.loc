<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Users;
use App\Controllers\Roles;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');

$routes->get('users', [Users::class, 'index']);
$routes->get('users/datatable', [Users::class, 'datatable']);
$routes->get('users/form/(:segment)', [Users::class, 'form']);
$routes->get('users/form', [Users::class, 'form']);
$routes->post('users/save/', [Users::class, 'save']);
$routes->post('users/delete/', [Users::class, 'delete']);
$routes->get('users/view', [Users::class, 'view']);
$routes->get('users/test', [Users::class, 'test']);

$routes->get('roles', [Roles::class, 'index']);
$routes->get('roles/index', [Roles::class, 'index']);
$routes->get('roles/datatable/(:any)', [Roles::class, 'datatable']);
$routes->get('roles/save/', [Roles::class, 'save']);
$routes->get('roles/view', [Roles::class, 'view']);

<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Users;
use App\Controllers\Roles;
use App\Controllers\SystemLogs;
use App\Controllers\Settings;
use App\Controllers\Dashboard;

/**
 * @var RouteCollection $routes
 */
$routes->get('users/login', [Users::class, 'login']);
$routes->post('users/authenticate', [Users::class, 'authenticate']);

$routes->group('', ['filter' => 'authFilter'], static function ($routes) {

    $routes->get('dashboard', [Dashboard::class, 'index']);

    $routes->get('users', [Users::class, 'index']);
    $routes->get('users/datatable', [Users::class, 'datatable']);
    $routes->get('users/form/(:segment)', [Users::class, 'form']);
    $routes->get('users/form', [Users::class, 'form']);
    $routes->post('users/save/', [Users::class, 'save']);
    $routes->post('users/delete/', [Users::class, 'delete']);
    $routes->get('users/profile', [Users::class, 'profile']);
    $routes->get('users/view', [Users::class, 'view']);
    $routes->get('users/logout', [Users::class, 'logout']);
    $routes->get('users/test', [Users::class, 'test']);

    $routes->get('roles', [Roles::class, 'index']);
    $routes->get('roles/index', [Roles::class, 'index']);
    $routes->get('roles/datatable', [Roles::class, 'datatable']);
    $routes->get('roles/form/(:segment)', [Roles::class, 'form']);
    $routes->get('roles/form', [Roles::class, 'form']);
    $routes->post('roles/save/', [Roles::class, 'save']);
    $routes->post('roles/delete/', [Roles::class, 'delete']);
    $routes->get('roles/view', [Roles::class, 'view']);

    $routes->get('(?i)systemLogs', [SystemLogs::class, 'index']);
    $routes->get('(?i)systemLogs/index', [SystemLogs::class, 'index']);
    $routes->get('(?i)systemLogs/datatable', [SystemLogs::class, 'datatable']);
    $routes->get('(?i)systemLogs/view', [SystemLogs::class, 'view']);
    $routes->get('(?i)systemLogs/test', [SystemLogs::class, 'test']);

    $routes->get('settings', [Settings::class, 'index']);
    $routes->get('settings/index', [Settings::class, 'index']);
    $routes->post('settings/save', [Settings::class, 'save']);
});

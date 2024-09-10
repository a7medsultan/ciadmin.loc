<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Base\Users;
use App\Controllers\Base\Roles;
use App\Controllers\Base\SystemLogs;
use App\Controllers\Base\Settings;
use App\Controllers\Base\Dashboard;

/**
 * @var RouteCollection $routes
 */
$routes->get('(?i)users/login', [Users::class, 'login']);
$routes->post('(?i)users/authenticate', [Users::class, 'authenticate']);

$routes->group('(?i)base', ['filter' => 'authFilter'], ["namespace" => "App\Controllers\Base"], static function ($routes) {
    $routes->get('(?i)users', [Users::class, 'index']);
    $routes->get('(?i)users/datatable', [Users::class, 'datatable']);
    $routes->get('(?i)users/form/(:segment)', [Users::class, 'form']);
    $routes->get('(?i)users/form', [Users::class, 'form']);
    $routes->post('(?i)users/save/', [Users::class, 'save']);
    $routes->post('(?i)users/delete/', [Users::class, 'delete']);
    $routes->get('(?i)users/profile', [Users::class, 'profile']);
    $routes->get('(?i)users/view', [Users::class, 'view']);
    $routes->get('(?i)users/logout', [Users::class, 'logout']);
    $routes->get('(?i)users/test', [Users::class, 'test']);

    $routes->get('roles', [Roles::class, 'index']);
    $routes->get('(?i)roles/datatable', [Roles::class, 'datatable']);
    $routes->get('(?i)roles/form/(:segment)', [Roles::class, 'form']);
    $routes->get('(?i)roles/form', [Roles::class, 'form']);
    $routes->post('(?i)roles/save/', [Roles::class, 'save']);
    $routes->post('(?i)roles/delete/', [Roles::class, 'delete']);

    $routes->get('(?i)systemLogs', [SystemLogs::class, 'index']);
    $routes->get('(?i)systemLogs/datatable', [SystemLogs::class, 'datatable']);
    $routes->get('(?i)systemLogs/view', [SystemLogs::class, 'view']);

    $routes->get('(?i)dashboard', [Dashboard::class, 'index']);
    $routes->get('(?i)settings', [Settings::class, 'index']);
    $routes->get('(?i)settings/index', [Settings::class, 'index']);
    $routes->post('(?i)settings/save', [Settings::class, 'save']);
});

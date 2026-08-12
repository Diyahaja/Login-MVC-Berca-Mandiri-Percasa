<?php

require_once __DIR__ . '/../config/config.php';

if (APP_DEBUG) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/UnitController.php';
require_once __DIR__ . '/../app/Controllers/TrnUnitController.php';

$router  = new Router();
$auth    = new AuthController();
$unit    = new UnitController();
$trnUnit = new TrnUnitController();

// ==== Routing: Auth ====
$router->get('auth-login', function () use ($auth) {
    $auth->showLogin();
});

$router->post('auth-login', function () use ($auth) {
    $auth->login();
});

$router->get('auth-logout', function () use ($auth) {
    $auth->logout();
});

// ==== Routing: Master Unit ====
$router->get('unit-index', function () use ($unit) {
    $unit->index();
});

$router->post('unit-store', function () use ($unit) {
    $unit->store();
});

$router->post('unit-update', function () use ($unit) {
    $unit->update();
});

$router->post('unit-delete', function () use ($unit) {
    $unit->delete();
});

// ==== Routing: Transaksi Unit ====
$router->get('trnunit-index', function () use ($trnUnit) {
    $trnUnit->index();
});

$router->post('trnunit-store', function () use ($trnUnit) {
    $trnUnit->store();
});

$router->post('trnunit-update', function () use ($trnUnit) {
    $trnUnit->update();
});

$router->post('trnunit-delete', function () use ($trnUnit) {
    $trnUnit->delete();
});

$router->get('dashboard', function () {
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php?page=auth&action=login');
        exit;
    }
    require __DIR__ . '/../app/Views/dashboard.php';
});

// ==== Tentukan route dari query string ====
$page   = $_GET['page'] ?? 'auth';
$action = $_GET['action'] ?? 'login';
$method = $_SERVER['REQUEST_METHOD'];

// Route khusus dashboard tidak perlu action
$routeKey = ($page === 'dashboard') ? 'dashboard' : $page . '-' . $action;

$router->dispatch($method, $routeKey);

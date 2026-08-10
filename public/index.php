<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

$router = new Router();
$auth   = new AuthController();

// ==== Routing ====
$router->get('auth-login', function () use ($auth) {
    $auth->showLogin();
});

$router->post('auth-login', function () use ($auth) {
    $auth->login();
});

$router->get('auth-logout', function () use ($auth) {
    $auth->logout();
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

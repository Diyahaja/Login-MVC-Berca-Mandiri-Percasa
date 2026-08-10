<?php

/**
 * Router
 * Router sederhana berbasis parameter GET 'page' & 'action'.
 * Contoh: index.php?page=auth&action=login
 */
class Router
{
    private array $routes = [];

    public function get(string $route, callable $handler): void
    {
        $this->routes['GET'][$route] = $handler;
    }

    public function post(string $route, callable $handler): void
    {
        $this->routes['POST'][$route] = $handler;
    }

    public function dispatch(string $method, string $route): void
    {
        $handler = $this->routes[$method][$route] ?? null;

        if ($handler === null) {
            http_response_code(404);
            echo '404 - Halaman tidak ditemukan';
            return;
        }

        call_user_func($handler);
    }
}

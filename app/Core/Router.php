<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Core;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];
    private array $middlewares = [];

    public function get(string $uri, callable|array $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, callable|array $action): void
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function middleware(string $middleware): self
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    public function start(): void
    {
        require __DIR__ . '/../../routes/web.php';

        $uri = parse_url((string) $_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
        $basePath = str_replace('\\', '/', dirname((string) $_SERVER['SCRIPT_NAME']));

        if ($basePath !== '/' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        $uri = '/' . trim($uri, '/');
        $uri = $uri === '//' ? '/' : $uri;

        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $routes = $this->routes[$method] ?? [];

        $action = null;
        $params = [];

        foreach ($routes as $route => $handler) {
            $pattern = preg_quote($route, '#');
            $pattern = preg_replace(
                '#\\\{([a-zA-Z_][a-zA-Z0-9_]*)\\\}#',
                '([^/]+)',
                $pattern
            );
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                preg_match_all(
                    '#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#',
                    $route,
                    $keys
                );

                $params = [];

                foreach ($keys[1] as $index => $name) {
                    $params[$name] = $matches[$index] ?? null;
                }

                $action = $handler;
                break;
            }
        }

        if (!$action) {
            http_response_code(404);
            $errorView = __DIR__ . '/../Views/errors/404.php';
            if (is_file($errorView)) {
                require $errorView;
            } else {
                echo '404 Not Found';
            }
            exit;
        }

        foreach ($this->middlewares as $middleware) {
            if (class_exists($middleware)) {
                (new $middleware())->handle();
            }
        }

        [$controller, $method] = $action;

        (new $controller())->$method(...$params);
    }
}
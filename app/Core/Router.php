<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Core;

class Router
{
    /**
     * @var Route[]
     */
    private array $routes = [];

    public function get(string $uri, callable|array $action): self
    {
        $this->routes[] = new Route(
            'GET',
            $uri,
            $action
        );

        return $this;
    }

    public function post(string $uri, callable|array $action): self
    {
        $this->routes[] = new Route(
            'POST',
            $uri,
            $action
        );

        return $this;
    }

    public function middleware(string $middleware): self
    {
        $route = end($this->routes);

        if ($route instanceof Route) {
            $route->middleware($middleware);
        }

        return $this;
    }

    public function start(): void
    {
        require __DIR__ . '/../../routes/web.php';

        $uri = parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/';

        $basePath = str_replace(
            '\\',
            '/',
            dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '/'))
        );

        if ($basePath !== '/' && str_starts_with($uri, $basePath)) {
            $uri = substr($uri, strlen($basePath));
        }

        $uri = '/' . trim($uri, '/');

        if ($uri === '//') {
            $uri = '/';
        }

        $requestMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        $matchedRoute = null;

        $params = [];

        foreach ($this->routes as $route) {

            if ($route->method !== $requestMethod) {
                continue;
            }

            $pattern = preg_quote($route->uri, '#');

            $pattern = preg_replace(
                '#\\\{([a-zA-Z_][a-zA-Z0-9_]*)\\\}#',
                '([^/]+)',
                $pattern
            );

            $pattern = '#^' . $pattern . '$#';

            if (!preg_match($pattern, $uri, $matches)) {
                continue;
            }

            array_shift($matches);

            preg_match_all(
                '#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#',
                $route->uri,
                $keys
            );

            foreach ($keys[1] as $index => $name) {
                $params[$name] = $matches[$index] ?? null;
            }

            $matchedRoute = $route;

            break;
        }

        if (!$matchedRoute) {

            http_response_code(404);

            $errorView = __DIR__ . '/../Views/errors/404.php';

            if (is_file($errorView)) {
                require $errorView;
            } else {
                echo '404 Not Found';
            }

            exit;
        }

        foreach ($matchedRoute->middlewares as $middleware) {

            if (class_exists($middleware)) {
                (new $middleware())->handle();
            }
        }

        $action = $matchedRoute->action;

        if (is_callable($action)) {
            $action(...$params);
            return;
        }

        [$controller, $method] = $action;

        (new $controller())->$method(...$params);
    }
}
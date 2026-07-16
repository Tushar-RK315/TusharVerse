<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Core;

class Route
{
    public function __construct(
        public string $method,
        public string $uri,
        public mixed $action,
        public array $middlewares = []
    ) {
    }

    public function middleware(string $middleware): self
    {
        $this->middlewares[] = $middleware;

        return $this;
    }
}


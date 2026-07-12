<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Middleware;

use TusharRk315\Tusharverse\Core\Response;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            (new Response())->redirect('/login');
        }
    }
}
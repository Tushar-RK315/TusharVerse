<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Middleware;

use TusharRk315\Tusharverse\Core\Response;
use TusharRk315\Tusharverse\Core\Session;

class GuestMiddleware implements MiddlewareInterface
{
    public function handle(): void
    {
        if (Session::has('user')) {
        (new Response())->redirect('/dashboard');
        return;
        }
    }
}

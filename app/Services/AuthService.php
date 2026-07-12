<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Services;

use TusharRk315\Tusharverse\Core\Session;

class AuthService
{
    public function login(array $user): void
    {
        Session::set('user', $user);
    }

    public function logout(): void
    {
        Session::remove('user');
    }

    public function check(): bool
    {
        return Session::has('user');
    }

    public function user(): ?array
    {
        return Session::get('user');
    }
}
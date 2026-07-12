<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Controllers;

use TusharRk315\Tusharverse\Core\Controller;

class AuthController extends Controller
{
    public function login(): void
    {
        $this->view('auth/login');
    }

    public function register(): void
    {
        $this->view('auth/register');
    }

    public function forgotPassword(): void
    {
        $this->view('auth/forgot-password');
    }

    public function resetPassword(): void
    {
        $this->view('auth/reset-password');
    }
}
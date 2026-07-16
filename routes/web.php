<?php

declare(strict_types=1);

use TusharRk315\Tusharverse\Controllers\HomeController;
use TusharRk315\Tusharverse\Controllers\AuthController;
use TusharRk315\Tusharverse\Controllers\DashboardController;
use TusharRk315\Tusharverse\Middleware\AuthMiddleware;
use TusharRk315\Tusharverse\Middleware\GuestMiddleware;

/** @var \TusharRk315\Tusharverse\Core\Router $this */

$this->get('/', [HomeController::class, 'index']);
$this->get('/about', [HomeController::class, 'about']);
$this->get('/projects', [HomeController::class, 'projects']);
$this->get('/project/{id}', [HomeController::class, 'project']);

$this->get('/login', [AuthController::class, 'login'])
    ->middleware(GuestMiddleware::class);

$this->get('/register', [AuthController::class, 'register'])
    ->middleware(GuestMiddleware::class);

$this->get('/forgot-password', [AuthController::class, 'forgotPassword'])
    ->middleware(GuestMiddleware::class);

$this->get('/reset-password', [AuthController::class, 'resetPassword'])
    ->middleware(GuestMiddleware::class);


$this->get('/logout', [AuthController::class, 'logout']);

$this->post('/login', [AuthController::class, 'authenticate']);
$this->post('/register', [AuthController::class, 'registerPost']);

$this->get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(AuthMiddleware::class);
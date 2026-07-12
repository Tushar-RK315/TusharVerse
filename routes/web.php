<?php

declare(strict_types=1);

use TusharRk315\Tusharverse\Controllers\HomeController;
use TusharRk315\Tusharverse\Controllers\AuthController;

/** @var \TusharRk315\Tusharverse\Core\Router $this */

$this->get('/', [HomeController::class, 'index']);
$this->get('/about', [HomeController::class, 'about']);
$this->get('/projects', [HomeController::class, 'projects']);
$this->get('/project/{id}', [HomeController::class, 'project']);

$this->get('/login', [AuthController::class, 'login']);
$this->get('/register', [AuthController::class, 'register']);
$this->get('/forgot-password', [AuthController::class, 'forgotPassword']);
$this->get('/reset-password', [AuthController::class, 'resetPassword']);

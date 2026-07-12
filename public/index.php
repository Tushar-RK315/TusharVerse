<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use TusharRk315\Tusharverse\Core\Router;
use TusharRk315\Tusharverse\Core\Database;
use TusharRk315\Tusharverse\Core\Session;

Database::connect();
Session::start();
$router = new Router();
$router->start();
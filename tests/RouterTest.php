<?php

require __DIR__ . '/../vendor/autoload.php';

use TusharRk315\Tusharverse\Core\Router;

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/test';
$_SERVER['SCRIPT_NAME'] = '/index.php';

$router = new Router();
$router->get('/test', function (): void {
    echo 'closure-ok';
});

ob_start();
$router->start();
$output = ob_get_clean();

if ($output !== 'closure-ok') {
    fwrite(STDERR, "Expected 'closure-ok', got '$output'\n");
    exit(1);
}

echo "Router closure test passed\n";

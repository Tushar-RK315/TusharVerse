<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Core;

class Controller
{
    protected function view(string $view): void
    {
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!is_file($viewPath)) {
            http_response_code(500);
            echo 'View not found: ' . htmlspecialchars($view, ENT_QUOTES, 'UTF-8');
            exit;
        }

        require $viewPath;
    }
}

<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Core;

class Response
{
    public function status(int $code): self
    {
        http_response_code($code);

        return $this;
    }

    public function redirect(string $url): never
    {
        if (str_starts_with($url, '/')) {
            $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
            $basePath = rtrim($basePath, '/');

            if ($basePath !== '' && $basePath !== '/' && !str_starts_with($url, $basePath)) {
                $url = $basePath . $url;
            }
        }

        header("Location: {$url}");
        exit;
    }

    public function json(array $data, int $status = 200): never
    {
        http_response_code($status);

        header('Content-Type: application/json');

        echo json_encode($data, JSON_PRETTY_PRINT);

        exit;
    }

    public function html(string $content): never
    {
        echo $content;

        exit;
    }
}
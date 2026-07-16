<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Core;

class Session
{
    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function flash(string $key, mixed $value): void
    {
        self::set("_flash.{$key}", $value);
    }

    public static function old(string $key, mixed $default = ''): mixed
    {
        $flashKey = "_flash.old.{$key}";

        if (!self::has($flashKey)) {
            return $default;
        }

        $value = self::get($flashKey);
        self::remove($flashKey);

        return $value;
    }

    public static function destroy(): void
    {
        session_destroy();
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }
}
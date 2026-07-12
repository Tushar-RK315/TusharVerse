<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Core;

class Flash
{
    public static function set(string $key, string $message): void
    {
        Session::set("_flash.{$key}", $message);
    }

    public static function get(string $key): ?string
    {
        $message = Session::get("_flash.{$key}");

        if ($message !== null) {
            Session::remove("_flash.{$key}");
        }

        return $message;
    }

    public static function has(string $key): bool
    {
        return Session::has("_flash.{$key}");
    }
}
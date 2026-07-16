<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Core;

class Csrf
{
    public static function generate(): string
    {
        if (!Session::has('_csrf_token')) {
            Session::set(
            '_csrf_token',
            bin2hex(random_bytes(32))
            );
            }

        return (string) Session::get('_csrf_token');
    }

    public static function verify(?string $token): bool
    {
        if (!Session::has('_csrf_token')) {
        return false;
        }

        return hash_equals(
        (string) Session::get('_csrf_token'),
        (string) $token
        );  
    }
}
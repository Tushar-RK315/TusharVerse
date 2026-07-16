<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Models;

class User
{
    public ?int $id = null;

    public string $name;

    public string $email;

    public string $password;

    public ?string $created_at = null;

    public ?string $updated_at = null;
}
<?php

declare(strict_types=1);

namespace TusharRk315\Tusharverse\Core;

class Validator
{
    private array $errors = [];

    public function required(string $field, mixed $value): self
    {
        $isEmpty = false;

        if (is_array($value)) {
            $isEmpty = empty($value);
        } else {
            $value = trim((string) $value);
            $isEmpty = $value === '';
        }

        if ($isEmpty) {
            $this->errors[$field][] = "The {$field} field is required.";
        }

        return $this;
    }

    public function email(string $field, mixed $value): self
    {
        if (!is_string($value) || !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "Invalid email address.";
        }

        return $this;
    }

    public function min(string $field, string $value, int $length): self
    {
        if (mb_strlen($value) < $length) {
            $this->errors[$field][] = "Minimum {$length} characters required.";
        }

        return $this;
    }

    public function max(string $field, string $value, int $length): self
    {
        if (mb_strlen($value) > $length) {
            $this->errors[$field][] = "Maximum {$length} characters allowed.";
        }

        return $this;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
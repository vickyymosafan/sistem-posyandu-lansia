<?php
namespace App\Validation;

class Validator
{
    private array $data;
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function required(string $field, string $label): self
    {
        $v = trim((string)($this->data[$field] ?? ''));
        if ($v === '') {
            $this->errors[$field] = "$label wajib diisi";
        }
        return $this;
    }

    public function maxLen(string $field, int $max, string $label): self
    {
        $v = (string)($this->data[$field] ?? '');
        if ($v !== '' && mb_strlen($v) > $max) {
            $this->errors[$field] = "$label maksimal $max karakter";
        }
        return $this;
    }

    public function date(string $field, string $label): self
    {
        $v = (string)($this->data[$field] ?? '');
        if ($v !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) {
            $this->errors[$field] = "$label tidak valid";
        }
        return $this;
    }

    public function enum(string $field, array $allowed, string $label): self
    {
        $v = (string)($this->data[$field] ?? '');
        if ($v !== '' && !in_array($v, $allowed, true)) {
            $this->errors[$field] = "$label tidak valid";
        }
        return $this;
    }

    public function regex(string $field, string $pattern, string $message): self
    {
        $v = (string)($this->data[$field] ?? '');
        if ($v !== '' && !preg_match($pattern, $v)) {
            $this->errors[$field] = $message;
        }
        return $this;
    }

    public function errors(): array { return $this->errors; }
    public function passes(): bool { return empty($this->errors); }
}


<?php

namespace App\Services\Beem;

class BeemSmsResponse
{
    public function __construct(
        private bool $successful,
        private string $message = '',
        private array $data = [],
    ) {}

    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function json(): array
    {
        return $this->data;
    }
}

<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final readonly class ApiKey
{
    public function __construct(public string $value)
    {
        $normalizedValue = trim($value);

        if ($normalizedValue === '') {
            throw new InvalidArgumentException('API key cannot be empty.');
        }
    }

    public function hash(): string
    {
        return hash('sha256', $this->value);
    }
}

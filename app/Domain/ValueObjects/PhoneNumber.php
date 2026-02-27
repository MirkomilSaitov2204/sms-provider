<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final readonly class PhoneNumber
{
    public function __construct(public string $value)
    {
        if (! preg_match('/^\+998\d{9}$/', $value)) {
            throw new InvalidArgumentException('Phone number must match +998XXXXXXXXX format.');
        }
    }
}

<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final readonly class MessageText
{
    public function __construct(public string $value)
    {
        $normalizedValue = trim($value);

        if ($normalizedValue === '') {
            throw new InvalidArgumentException('Message cannot be empty.');
        }

        if (mb_strlen($normalizedValue) > 1000) {
            throw new InvalidArgumentException('Message is too long.');
        }
    }
}

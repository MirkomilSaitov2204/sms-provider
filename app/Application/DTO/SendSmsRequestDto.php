<?php

namespace App\Application\DTO;

/**
 * @phpstan-type SendSmsRequestData array{
 *     api_key: string,
 *     phones: list<string>,
 *     message: string
 * }
 */
final readonly class SendSmsRequestDto
{
    /**
     * @param list<string> $phones
     */
    public function __construct(
        public string $apiKey,
        public array $phones,
        public string $message,
    ) {
    }

    /**
     * @param SendSmsRequestData $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            apiKey: $data['api_key'],
            phones: $data['phones'],
            message: $data['message'],
        );
    }
}

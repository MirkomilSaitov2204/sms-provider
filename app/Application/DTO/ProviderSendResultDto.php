<?php

namespace App\Application\DTO;

use App\Domain\Enums\SmsStatus;

final readonly class ProviderSendResultDto
{
    /**
     * @param array<string, mixed> $providerResponse
     */
    public function __construct(
        public SmsStatus $status,
        public ?string $providerMessageId,
        public array $providerResponse,
        public ?string $failureReason = null,
    ) {
    }
}

<?php

namespace App\Application\DTO;

final readonly class SendSmsResultDto
{
    public function __construct(
        public int $acceptedCount,
        public int $queuedCount,
    ) {
    }

    /**
     * @return array{accepted_count: int, queued_count: int}
     */
    public function toArray(): array
    {
        return [
            'accepted_count' => $this->acceptedCount,
            'queued_count' => $this->queuedCount,
        ];
    }
}

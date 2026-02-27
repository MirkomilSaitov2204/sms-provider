<?php

namespace App\Application\DTO;

final readonly class SmsHistoryFilterDto
{
    public function __construct(
        public string $apiKey,
        public ?string $status,
        public ?string $phone,
        public ?string $dateFrom,
        public ?string $dateTo,
        public int $perPage = 15,
    ) {
    }

    /**
     * @param array{
     *   api_key: string,
     *   status?: ?string,
     *   phone?: ?string,
     *   date_from?: ?string,
     *   date_to?: ?string,
     *   per_page?: int
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            apiKey: $data['api_key'],
            status: $data['status'] ?? null,
            phone: $data['phone'] ?? null,
            dateFrom: $data['date_from'] ?? null,
            dateTo: $data['date_to'] ?? null,
            perPage: $data['per_page'] ?? 15,
        );
    }
}

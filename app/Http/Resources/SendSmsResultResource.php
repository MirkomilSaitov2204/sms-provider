<?php

namespace App\Http\Resources;

use App\Application\DTO\SendSmsResultDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SendSmsResultDto */
class SendSmsResultResource extends JsonResource
{
    /**
     * @return array{accepted_count: int, queued_count: int}
     */
    public function toArray(Request $request): array
    {
        return [
            'accepted_count' => $this->acceptedCount,
            'queued_count' => $this->queuedCount,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Domain\Enums\SmsStatus;
use App\Models\SmsMessage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin SmsMessage */
class SmsMessageResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $status = $this->status instanceof SmsStatus ? $this->status->value : (string) $this->status;

        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'phone' => $this->phone,
            'message' => $this->message,
            'status' => $status,
            'provider_code' => $this->provider_code,
            'provider_message_id' => $this->provider_message_id,
            'provider_response' => $this->provider_response,
            'queued_at' => $this->queued_at,
            'sent_at' => $this->sent_at,
            'delivered_at' => $this->delivered_at,
            'failed_at' => $this->failed_at,
            'failure_reason' => $this->failure_reason,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

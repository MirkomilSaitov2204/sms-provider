<?php

namespace App\Infrastructure\SmsProviders;

use App\Application\DTO\ProviderSendResultDto;
use App\Domain\Contracts\SmsProviderInterface;
use App\Domain\Enums\SmsStatus;
use App\Domain\ValueObjects\MessageText;
use App\Domain\ValueObjects\PhoneNumber;
use App\Models\Project;
use Illuminate\Support\Str;

class FakeProvider implements SmsProviderInterface
{
    public function send(Project $project, PhoneNumber $phoneNumber, MessageText $messageText): ProviderSendResultDto
    {
        return new ProviderSendResultDto(
            status: SmsStatus::Delivered,
            providerMessageId: 'fake-'.Str::uuid()->toString(),
            providerResponse: [
                'provider' => 'fake',
                'project_id' => $project->id,
                'phone' => $phoneNumber->value,
                'message' => $messageText->value,
            ],
        );
    }
}

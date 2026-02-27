<?php

namespace App\Domain\Contracts;

use App\Application\DTO\ProviderSendResultDto;
use App\Domain\ValueObjects\MessageText;
use App\Domain\ValueObjects\PhoneNumber;
use App\Models\Project;

interface SmsProviderInterface
{
    public function send(Project $project, PhoneNumber $phoneNumber, MessageText $messageText): ProviderSendResultDto;
}

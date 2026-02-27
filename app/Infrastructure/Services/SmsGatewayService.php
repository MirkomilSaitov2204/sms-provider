<?php

namespace App\Infrastructure\Services;

use App\Application\DTO\ProviderSendResultDto;
use App\Domain\Contracts\ProviderResolverInterface;
use App\Domain\Contracts\SmsGatewayServiceInterface;
use App\Domain\Enums\SmsProviderCode;
use App\Domain\ValueObjects\MessageText;
use App\Domain\ValueObjects\PhoneNumber;
use App\Models\Project;

class SmsGatewayService implements SmsGatewayServiceInterface
{
    public function __construct(private readonly ProviderResolverInterface $providerResolver)
    {
    }

    public function send(Project $project, PhoneNumber $phoneNumber, MessageText $messageText): ProviderSendResultDto
    {
        /** @var SmsProviderCode $providerCode */
        $providerCode = $project->provider_code;
        $provider = $this->providerResolver->resolve($providerCode);

        return $provider->send($project, $phoneNumber, $messageText);
    }
}

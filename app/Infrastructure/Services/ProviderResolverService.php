<?php

namespace App\Infrastructure\Services;

use App\Domain\Contracts\ProviderResolverInterface;
use App\Domain\Contracts\SmsProviderInterface;
use App\Domain\Enums\SmsProviderCode;
use App\Domain\Exceptions\ProviderNotSupportedException;
use App\Infrastructure\SmsProviders\EskizProvider;
use App\Infrastructure\SmsProviders\FakeProvider;
use App\Infrastructure\SmsProviders\PlaymobileProvider;

class ProviderResolverService implements ProviderResolverInterface
{
    public function __construct(
        private readonly EskizProvider $eskizProvider,
        private readonly PlaymobileProvider $playmobileProvider,
        private readonly FakeProvider $fakeProvider,
    ) {
    }

    public function resolve(SmsProviderCode $providerCode): SmsProviderInterface
    {
        return match ($providerCode) {
            SmsProviderCode::Eskiz => $this->eskizProvider,
            SmsProviderCode::Playmobile => $this->playmobileProvider,
            SmsProviderCode::Fake => $this->fakeProvider,
            default => throw new ProviderNotSupportedException('Provider is not supported.'),
        };
    }
}

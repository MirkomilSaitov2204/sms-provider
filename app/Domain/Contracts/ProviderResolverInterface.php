<?php

namespace App\Domain\Contracts;

use App\Domain\Enums\SmsProviderCode;

interface ProviderResolverInterface
{
    public function resolve(SmsProviderCode $providerCode): SmsProviderInterface;
}

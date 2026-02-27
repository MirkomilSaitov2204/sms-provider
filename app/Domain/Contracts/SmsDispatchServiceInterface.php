<?php

namespace App\Domain\Contracts;

use App\Models\SmsMessage;

interface SmsDispatchServiceInterface
{
    public function dispatch(SmsMessage $smsMessage): void;
}

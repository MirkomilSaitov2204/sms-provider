<?php

namespace App\Domain\Enums;

enum SmsProviderCode: string
{
    case Eskiz = 'eskiz';
    case Playmobile = 'playmobile';
    case Fake = 'fake';
}

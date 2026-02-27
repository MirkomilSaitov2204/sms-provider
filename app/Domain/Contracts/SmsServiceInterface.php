<?php

namespace App\Domain\Contracts;

use App\Application\DTO\SendSmsRequestDto;
use App\Application\DTO\SendSmsResultDto;
use App\Application\DTO\SmsHistoryFilterDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SmsServiceInterface
{
    public function send(SendSmsRequestDto $dto): SendSmsResultDto;

    public function history(SmsHistoryFilterDto $dto): LengthAwarePaginator;
}

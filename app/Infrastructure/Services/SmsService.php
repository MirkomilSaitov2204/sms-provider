<?php

namespace App\Infrastructure\Services;

use App\Application\DTO\SendSmsRequestDto;
use App\Application\DTO\SendSmsResultDto;
use App\Application\DTO\SmsHistoryFilterDto;
use App\Domain\Contracts\ProjectResolverInterface;
use App\Domain\Contracts\SmsServiceInterface;
use App\Domain\Enums\SmsStatus;
use App\Domain\ValueObjects\ApiKey;
use App\Domain\ValueObjects\MessageText;
use App\Domain\ValueObjects\PhoneNumber;
use App\Jobs\DispatchSmsJob;
use App\Models\SmsMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SmsService implements SmsServiceInterface
{
    public function __construct(private ProjectResolverInterface $projectResolver)
    {
    }

    public function send(SendSmsRequestDto $dto): SendSmsResultDto
    {
        $project = $this->projectResolver->resolveByApiKey(new ApiKey($dto->apiKey));
        $messageText = new MessageText($dto->message);
        $queuedCount = 0;

        DB::transaction(function () use ($dto, $project, $messageText, &$queuedCount): void {
            foreach ($dto->phones as $phone) {
                $phoneNumber = new PhoneNumber($phone);

                $smsMessage = SmsMessage::query()->create([
                    'project_id' => $project->id,
                    'phone' => $phoneNumber->value,
                    'message' => $messageText->value,
                    'status' => SmsStatus::Pending,
                    'provider_code' => $project->providerCodeValue(),
                    'queued_at' => now(),
                ]);

                DispatchSmsJob::dispatch($smsMessage->id);
                $queuedCount++;
            }
        });

        return new SendSmsResultDto(
            acceptedCount: count($dto->phones),
            queuedCount: $queuedCount,
        );
    }

    public function history(SmsHistoryFilterDto $dto): LengthAwarePaginator
    {
        $project = $this->projectResolver->resolveByApiKey(new ApiKey($dto->apiKey));

        return SmsMessage::query()
            ->where('project_id', $project->id)
            ->when($dto->status !== null, function ($query) use ($dto): void {
                $query->where('status', $dto->status);
            })
            ->when($dto->phone !== null, function ($query) use ($dto): void {
                $query->where('phone', $dto->phone);
            })
            ->when($dto->dateFrom !== null, function ($query) use ($dto): void {
                $query->whereDate('created_at', '>=', $dto->dateFrom);
            })
            ->when($dto->dateTo !== null, function ($query) use ($dto): void {
                $query->whereDate('created_at', '<=', $dto->dateTo);
            })
            ->latest('id')
            ->paginate($dto->perPage);
    }
}

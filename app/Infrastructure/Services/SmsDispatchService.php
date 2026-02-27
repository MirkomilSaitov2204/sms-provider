<?php

namespace App\Infrastructure\Services;

use App\Domain\Contracts\SmsDispatchServiceInterface;
use App\Domain\Contracts\SmsGatewayServiceInterface;
use App\Domain\Enums\SmsStatus;
use App\Domain\ValueObjects\MessageText;
use App\Domain\ValueObjects\PhoneNumber;
use App\Models\SmsMessage;
use Throwable;

class SmsDispatchService implements SmsDispatchServiceInterface
{
    public function __construct(private readonly SmsGatewayServiceInterface $smsGatewayService)
    {
    }

    public function dispatch(SmsMessage $smsMessage): void
    {
        try {
            $result = $this->smsGatewayService->send(
                $smsMessage->project,
                new PhoneNumber($smsMessage->phone),
                new MessageText($smsMessage->message),
            );

            $status = $result->status;

            $smsMessage->update([
                'status' => $status,
                'provider_message_id' => $result->providerMessageId,
                'provider_response' => $result->providerResponse,
                'sent_at' => in_array($status, [SmsStatus::Sent, SmsStatus::Delivered], true) ? now() : null,
                'delivered_at' => $status === SmsStatus::Delivered ? now() : null,
                'failed_at' => $status === SmsStatus::Failed ? now() : null,
                'failure_reason' => $result->failureReason,
            ]);
        } catch (Throwable $exception) {
            $smsMessage->update([
                'status' => SmsStatus::Failed,
                'provider_response' => [
                    'exception' => $exception->getMessage(),
                ],
                'failed_at' => now(),
                'failure_reason' => $exception->getMessage(),
            ]);
        }
    }
}

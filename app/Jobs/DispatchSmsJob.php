<?php

namespace App\Jobs;

use App\Domain\Contracts\SmsDispatchServiceInterface;
use App\Models\SmsMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DispatchSmsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $smsMessageId)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(SmsDispatchServiceInterface $smsDispatchService): void
    {
        $smsMessage = SmsMessage::query()
            ->with('project')
            ->find($this->smsMessageId);

        if ($smsMessage === null) {
            return;
        }

        $smsDispatchService->dispatch($smsMessage);
    }
}

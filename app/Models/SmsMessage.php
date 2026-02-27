<?php

namespace App\Models;

use App\Domain\Enums\SmsStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsMessage extends Model
{
    /** @use HasFactory<\Database\Factories\SmsMessageFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'project_id',
        'phone',
        'message',
        'status',
        'provider_code',
        'provider_message_id',
        'provider_response',
        'queued_at',
        'sent_at',
        'delivered_at',
        'failed_at',
        'failure_reason',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => SmsStatus::class,
            'provider_response' => 'array',
            'queued_at' => 'immutable_datetime',
            'sent_at' => 'immutable_datetime',
            'delivered_at' => 'immutable_datetime',
            'failed_at' => 'immutable_datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}

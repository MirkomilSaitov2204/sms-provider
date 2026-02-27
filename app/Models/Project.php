<?php

namespace App\Models;

use App\Domain\Enums\SmsProviderCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'provider_code',
        'api_key_hash',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'provider_code' => SmsProviderCode::class,
            'is_active' => 'boolean',
        ];
    }

    public function smsMessages(): HasMany
    {
        return $this->hasMany(SmsMessage::class);
    }

    public function providerCodeValue(): string
    {
        return $this->provider_code instanceof SmsProviderCode
            ? $this->provider_code->value
            : (string) $this->provider_code;
    }
}

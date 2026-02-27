<?php

namespace Database\Factories;

use App\Domain\Enums\SmsProviderCode;
use App\Domain\Enums\SmsStatus;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SmsMessage>
 */
class SmsMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'phone' => '+998'.fake()->numerify('#########'),
            'message' => fake()->sentence(),
            'status' => fake()->randomElement([
                SmsStatus::Pending,
                SmsStatus::Sent,
                SmsStatus::Delivered,
                SmsStatus::Failed,
            ]),
            'provider_code' => fake()->randomElement([
                SmsProviderCode::Fake->value,
                SmsProviderCode::Eskiz->value,
                SmsProviderCode::Playmobile->value,
            ]),
            'provider_message_id' => fake()->uuid(),
            'provider_response' => ['mock' => true],
            'queued_at' => now()->subMinute(),
            'sent_at' => now(),
        ];
    }
}

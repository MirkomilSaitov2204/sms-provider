<?php

namespace Database\Factories;

use App\Domain\Enums\SmsProviderCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->sentence(),
            'provider_code' => fake()->randomElement([
                SmsProviderCode::Fake,
                SmsProviderCode::Eskiz,
                SmsProviderCode::Playmobile,
            ]),
            'api_key_hash' => hash('sha256', fake()->sha1()),
            'is_active' => true,
        ];
    }
}

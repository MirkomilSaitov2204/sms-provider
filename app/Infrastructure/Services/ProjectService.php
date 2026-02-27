<?php

namespace App\Infrastructure\Services;

use App\Domain\Contracts\ProjectServiceInterface;
use App\Domain\Enums\SmsProviderCode;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectService implements ProjectServiceInterface
{
    public function create(array $payload): array
    {
        $apiKey = Str::random(64);

        $project = Project::query()->create([
            'name' => $payload['name'],
            'description' => $payload['description'] ?? null,
            'provider_code' => SmsProviderCode::from($payload['provider_code']),
            'api_key_hash' => hash('sha256', $apiKey),
            'is_active' => true,
        ]);

        return [
            'project' => $project,
            'api_key' => $apiKey,
        ];
    }

    public function updateProvider(Project $project, array $payload): Project
    {
        $project->update([
            'provider_code' => SmsProviderCode::from($payload['provider_code']),
        ]);

        return $project->refresh();
    }
}

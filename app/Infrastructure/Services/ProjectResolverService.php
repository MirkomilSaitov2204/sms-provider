<?php

namespace App\Infrastructure\Services;

use App\Domain\Contracts\ProjectResolverInterface;
use App\Domain\Exceptions\InvalidApiKeyException;
use App\Domain\ValueObjects\ApiKey;
use App\Models\Project;

class ProjectResolverService implements ProjectResolverInterface
{
    public function resolveByApiKey(ApiKey $apiKey): Project
    {
        $project = Project::query()
            ->where('api_key_hash', $apiKey->hash())
            ->where('is_active', true)
            ->first();

        if ($project === null) {
            throw new InvalidApiKeyException('Invalid API key.');
        }

        return $project;
    }
}

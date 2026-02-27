<?php

namespace App\Domain\Contracts;

use App\Domain\ValueObjects\ApiKey;
use App\Models\Project;

interface ProjectResolverInterface
{
    public function resolveByApiKey(ApiKey $apiKey): Project;
}

<?php

namespace App\Domain\Contracts;

use App\Models\Project;

interface ProjectServiceInterface
{
    /**
     * @param array{name: string, description?: ?string, provider_code: string} $payload
     * @return array{project: Project, api_key: string}
     */
    public function create(array $payload): array;

    /**
     * @param array{provider_code: string} $payload
     */
    public function updateProvider(Project $project, array $payload): Project;
}

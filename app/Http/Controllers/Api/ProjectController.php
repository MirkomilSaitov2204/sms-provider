<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\ProjectServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateProjectRequest;
use App\Http\Requests\Api\UpdateProjectProviderRequest;
use App\Http\Resources\ProjectCreatedResource;
use App\Http\Resources\ProjectResource;
use App\Http\Responses\ApiResponse;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function store(CreateProjectRequest $request, ProjectServiceInterface $projectService): JsonResponse
    {
        $result = $projectService->create($request->validated());

        return ApiResponse::success(new ProjectCreatedResource($result), status: 201);
    }

    public function updateProvider(
        UpdateProjectProviderRequest $request,
        Project $project,
        ProjectServiceInterface $projectService,
    ): JsonResponse {
        $updatedProject = $projectService->updateProvider($project, $request->validated());

        return ApiResponse::success(new ProjectResource($updatedProject));
    }
}

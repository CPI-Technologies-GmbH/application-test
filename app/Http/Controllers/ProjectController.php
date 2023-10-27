<?php

namespace App\Http\Controllers;

use App\Http\Factories\ProjectDTOFactory;
use App\Http\Repositories\ProjectRepository;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectRepository $projectRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProjectResource::collection($this->projectRepository->getUserProjects(auth()->user()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectCreateRequest $request)
    {
        return new ProjectResource($this->projectRepository->createProject(ProjectDTOFactory::fromRequest($request)));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ProjectResource($this->projectRepository->getUserProjectById(auth()->user(), $id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectUpdateRequest $request, string $id)
    {
        return new ProjectResource($this->projectRepository->updateProject(auth()->user(), $id, ProjectDTOFactory::fromRequest($request)));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->projectRepository->deleteProject(auth()->user(), $id);
        return response('', $result ? 204 : 404);
    }

}

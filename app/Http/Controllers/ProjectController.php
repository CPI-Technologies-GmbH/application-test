<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Project\CreateRequest;
use App\Http\Requests\Api\Project\EditProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;

class ProjectController extends Controller
{
    public function create(CreateRequest $request)
    {
        // Create a new project
        $validData = $request->validated();

        $project = Project::create([
            'name' => $validData['name'],
            'description' => $validData['description'],
            'user_id' => \Auth::id(),
        ]);

        // Return the created project
        return new ProjectResource($project);
    }

    public function update(EditProjectRequest $request, Project $project)
    {
        $valid_data = $request->validated();

        unset($valid_data['user_id']);

        $project->fill($valid_data);
        $project->save();

        return new ProjectResource($project);

    }

    public function remove(Project $project)
    {
        $project->delete();

        return response(status: 204);

    }

    public function show(Project $project)
    {
        return new ProjectResource($project);
    }
}

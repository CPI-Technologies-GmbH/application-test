<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\CreateRequest;
use App\Http\Resources\Api\Project\ProjectResource;
use App\Models\Project;

class CreateProjectController extends Controller
{
    public function __invoke(CreateRequest $request)
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
}

<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Project\EditProjectRequest;
use App\Http\Resources\Api\Project\ProjectResource;
use App\Models\Project;

class UpdateProjectController extends Controller
{
    public function __invoke(EditProjectRequest $request, Project $project)
    {
        $valid_data = $request->validated();

        unset($valid_data['user_id']);

        $project->fill($valid_data);
        $project->save();

        return new ProjectResource($project);

    }
}

<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Project\ProjectResource;
use App\Models\Project;

class ShowProjectController extends Controller
{
    public function __invoke(Project $project)
    {
        return new ProjectResource($project);
    }
}

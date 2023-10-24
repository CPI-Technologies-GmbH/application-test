<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;

class RemoveProjectController extends Controller
{
    public function __invoke(Project $project)
    {
        $project->delete();

        return response(status: 204);

    }
}

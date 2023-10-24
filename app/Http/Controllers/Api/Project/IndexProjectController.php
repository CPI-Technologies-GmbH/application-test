<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Project\ProjectResourceCollection;
use App\Models\Project;

class IndexProjectController extends Controller
{
    public function __invoke(): ProjectResourceCollection
    {
        return new ProjectResourceCollection(Project::query()->where('user_id', \Auth::id())->paginate());
    }
}

<?php

namespace App\Http\Controllers\Api\TimeTracking;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TimeTracking;
use Carbon\Carbon;

class StartTimeTrackingController extends Controller
{
    public function __invoke(Project $project)
    {

        if (TimeTracking::query()->where('user_id', \Auth::id())->where('project_id', $project->id)->whereNull('end_time')->exists()) {
            $msg = sprintf('Tracking time for project: %s is already stared', $project->name);

            return response($msg, 422);
        }

        TimeTracking::query()->create(
            [
                'user_id' => \Auth::id(),
                'project_id' => $project->id,
                'start_time' => Carbon::now(),
            ]
        );

        $msg = sprintf('Start tracking time for project: %s', $project->name);

        return response($msg, 200);
    }
}

<?php

namespace App\Http\Controllers\Api\TimeTracking;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TimeTracking;
use Carbon\Carbon;

class StopTimeTrackingController extends Controller
{
    public function __invoke(Project $project)
    {

        if (! TimeTracking::query()->where('user_id', \Auth::id())->where('project_id', $project->id)->whereNull('end_time')->exists()) {
            $msg = sprintf('No active tracked time for project: %s', $project->name);

            return response($msg, 422);
        }

        TimeTracking::query()->where('user_id', \Auth::id())->where('project_id', $project->id)->update(
            [
                'end_time' => Carbon::now(),
            ]
        );

        $msg = sprintf('Stop tracking time for project: %s', $project->name);

        return response($msg, 200);
    }
}

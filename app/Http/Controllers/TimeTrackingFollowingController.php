<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\TimeTrackingFollowing;
use App\Http\Resources\TimeTrackingFollowingResource;

class TimeTrackingFollowingController extends Controller
{
    public function start(Request $request, Projects $project)
    {
        $this->authorize('update', $project);

        $timeTrackingFollowing = $project->timeTrackingFollowings()->create([
            'start_time' => now(),
        ]);

        return new TimeTrackingFollowingResource($timeTrackingFollowing);
    }

    public function end(Request $request, Projects $project, TimeTrackingFollowing $timeTrackingFollowing)
    {
        $this->authorize('update', $project);

        $timeTrackingFollowing->update([
            'end_time' => now(),
        ]);

        return new TimeTrackingFollowingResource($timeTrackingFollowing);
    }
}

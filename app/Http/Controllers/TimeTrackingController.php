<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeTracking;
use App\Http\Resources\TimeTrackingResource;

class TimeTrackingController extends Controller
{
    public function index()
    {
        $timeTrackings = TimeTracking::all();
        return TimeTrackingResource::collection($timeTrackings);
    }

    public function store(Request $request)
    {
       $timetracking = TimeTracking::create([
            'project_id' => $request->project_id,
            'user_id' => $request->user_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'tracked' => $request->tracked
        ]);
        
        return new TimeTrackingResource($timetracking);
    }

    public function show(string $id)
    {
        $user = auth()->user();
        $timetracking = TimeTracking::findOrFail($id);
        return new TimeTrackingResource($timetracking);
    }

    public function update(Request $request, string $id)
    {
        $timetracking = TimeTracking::findOrFail($id);

            $timetracking->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'tracked' => $request->tracked
            ]);
            return new TimeTrackingResource($timetracking);
    }
   
    public function destroy(string $id)
    {
        $timeTracking = TimeTracking::findOrFail($id);
        $timeTracking->delete();

        return response()->json(['message' => 'Time tracking record deleted successfully']);    
    }

    public function startTracking(Request $request, string $id)
    {
        $timetracking = TimeTracking::findOrFail($id);

        if($timetracking->isTracked()) {
            return response()->json(['message' => 'Time tracking record is already tracked.'], 403);
        }
        else
        {
            $timetracking->update([
                'start_time' => $request->start_time,
                'tracked' => '0'
            ]);
            return new TimeTrackingResource($timetracking);
        }
    }

    public function stopTracking(Request $request, string $id)
    {

        $timetracking = TimeTracking::findOrFail($id);

        if(!$timetracking->isTracked()) {
            return response()->json(['message' => 'Time tracking record is not tracked.'], 403);
        }
        else
        {
            $timetracking->update([
                'end_time' => $request->end_time,
                'tracked' => '1'
            ]);
            return new TimeTrackingResource($timetracking);
        }
    }
}


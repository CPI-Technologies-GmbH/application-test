<?php

namespace App\Http\Repositories;

use App\Models\Timetrack;
use App\Models\User;
use Illuminate\Support\Carbon;

class TimetrackRepository
{
    /**
     * Start timer
     *
     * @param User $user
     * @param int $projectId
     * @return bool
     */
    public function startTimer(User $user, int $projectId): bool
    {
        // Already exists
        $timetrack = Timetrack::where('user_id', $user->id)
            ->where('project_id', $projectId)
            ->orderBy('created_at', 'DESC')
            ->first();
        if ($timetrack && !$timetrack->end_time) {
            return false;
        }
        // New one
        $result = Timetrack::create([
            'user_id' => $user->id,
            'project_id' => $projectId,
            'start_time' => Carbon::now()
        ]);
        return !empty($result);
    }

    /**
     * End timer
     *
     * @param User $user
     * @param int $projectId
     * @return bool
     */
    public function endTimer(User $user, int $projectId): bool
    {
        /* @var Timetrack $timetrack */
        $timetrack = Timetrack::where('user_id', $user->id)
            ->where('project_id', $projectId)
            ->orderBy('created_at', 'DESC')
            ->first();

        if ($timetrack) {
            // Already stopped
            if ($timetrack->end_time) {
                return false;
            }
            // Stop it now
            $timetrack->end_time = Carbon::now();
            $result = $timetrack->save();
        }
        return ($timetrack && $result);
    }

}

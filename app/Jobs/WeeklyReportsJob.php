<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\WeeklyTimeReportNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WeeklyReportsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $endTime = Carbon::now()->endOfDay();
        $startTime = Carbon::now()->subDays(7)->startOfDay();

        User::query()
//           ->whereHas('timeTrackings', function (Builder $query) use ($endTime, $startTime) {
//           $query->whereBetween('start_time', [$startTime, $endTime])->whereNotNull('end_time');
//       })
            ->leftJoin('time_trackings', 'users.id', 'time_trackings.user_id')
            ->whereBetween('time_trackings.start_time', [$startTime, $endTime])
            ->whereNotNull('time_trackings.end_time')
            ->selectRaw('users.*, TIMEDIFF(time_trackings.end_time , time_trackings.start_time) AS totalTimeInCurrentWeek')
            ->get()->each(function (User $user) {
                $user->notify(new WeeklyTimeReportNotification($user->totalTimeInCurrentWeek));
            });
    }
}

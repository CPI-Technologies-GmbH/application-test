<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\TimeTrackingReport;

class SendTimeTrackingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-time-tracking-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send time tracking report by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::whereHas('projects.timeTrackingFollowings', function ($query) {
            $query->whereNotNull('end_time')
                ->where('end_time', '>', now()->subWeek());
        })
            ->chunk(200, function ($users) {
                foreach($users as $user) {
                    $user->notify(new TimeTrackingReport($user));
                }
            });
    }
}

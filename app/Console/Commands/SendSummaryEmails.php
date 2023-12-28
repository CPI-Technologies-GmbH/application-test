<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\TimeTrackingSummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendSummaryEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        // Fetch all users
    $users = User::all();

    foreach ($users as $user) {
        // Fetch the user's time tracking data for the past week
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $timeTrackings = $user->timeTrackings()
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->get();

        // Calculate the summary
        $totalTime = $timeTrackings->sum('duration');

        // Send the email
        Mail::to($user->email)->send(new TimeTrackingSummary($totalTime));
    }
    }
}

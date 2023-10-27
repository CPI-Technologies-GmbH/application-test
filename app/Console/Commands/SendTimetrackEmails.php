<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendTimetrackEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-timetrack-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to all users that summarizes their time tracking';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timetrack = DB::table('timetrack')
            ->selectRaw('users.name, users.email, projects.name, timetrack.user_id as userid, timetrack.project_id as projectid, '.
                'SEC_TO_TIME( SUM(TIME_TO_SEC(timetrack.end_time) - TIME_TO_SEC(timetrack.start_time))) as sptime')
            ->leftJoin('users', 'timetrack.user_id', '=', 'users.id')
            ->leftJoin('projects', 'timetrack.project_id', '=', 'projects.id')
            ->where('timetrack.created_at', '>', 'DATE_SUB(NOW(), INTERVAL 1 WEEK)')
            ->groupBy('userid', 'projectid')
            ->get();

        $data = [];
        foreach ($timetrack as $tData) {
            $data[$tData->email][] = [
                'project_name' => $tData->name,
                'spend_time' => $tData->sptime,
            ];
        }

        $this->sendEmails($data);
    }

    protected function sendEmails($data)
    {
        // Future actions depends from mail sending process
        print_r($data);
    }
}

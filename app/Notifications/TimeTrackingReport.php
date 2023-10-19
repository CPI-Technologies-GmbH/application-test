<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class TimeTrackingReport extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $this->user->load(['projects' => function ($query) {
            $query->whereHas('timeTrackingFollowings', function ($query2) {
                $query2->whereNotNull('end_time')
                    ->where('end_time', '>', now()->subWeek());
            })
            ->with('timeTrackingFollowings');
        }]);

        $message = (new MailMessage)
            ->line('Weekly Time Tracking Report.');

        foreach ($this->user->projects as $project) {
            $message->line('Project ID: ' . $project->id);
            $message->line('Recorded Time Trackings: ');
            foreach($project->timeTrackingFollowings as $timeTrackingFollowing) {
                $message->line($timeTrackingFollowing->start_time->toDateTimeString() . ' - ' . $timeTrackingFollowing->end_time->toDateTimeString());
            }
            $message->line('///////////////////////');
        }

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

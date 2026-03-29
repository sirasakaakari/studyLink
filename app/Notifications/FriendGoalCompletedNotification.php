<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FriendGoalCompletedNotification extends Notification
{
    use Queueable;

    public function __construct(public $user, public $goal) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'friend_goal_completed',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'goal_title' => $this->goal->title,
        ];
    }
}


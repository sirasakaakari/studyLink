<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CelebrationReceivedNotification extends Notification
{
    use Queueable;

    protected $fromUser;
    protected $goalId;

    public function __construct($fromUser, $goalId)
    {
        $this->fromUser = $fromUser;
        $this->goalId = $goalId;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'celebration_received',
            'goal_id' => $this->goalId,
            'from_user_id' => $this->fromUser->id,
            'from_user_name' => $this->fromUser->name,
            'message' => $this->fromUser->name . 'さんがあなたをお祝いしました🥂'
        ];
    }
}

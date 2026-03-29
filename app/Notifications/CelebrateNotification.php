<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CelebrateNotification extends Notification
{
    use Queueable;

    public function __construct(public $fromUser) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'celebrated',
            'message' => "{$this->fromUser->name}さんがあなたをお祝いしました🥂"
        ];
    }
}

<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GoalCompletedNotification extends Notification
{
    use Queueable;

    public function __construct(public $goal) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "🎉 おめでとう！「{$this->goal->title}」を達成しました！",
            'goal_id' => $this->goal->id,
        ];
    }
}

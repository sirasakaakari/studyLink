<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MutualGoalCompletedNotification extends Notification
{
    use Queueable;

    protected $goal;

    public function __construct($goal)
    {
        $this->goal = $goal;
    }

    // ⭐ database通知に変更
    public function via($notifiable)
    {
        return ['database'];
    }
    
    public function toArray($notifiable)
    {
        return [
            'goal_id' => $this->goal->id,
            'user_id' => $this->goal->user->id,
            'user_name' => $this->goal->user->name,
            'message' => $this->goal->user->name . 'さんが学習目標を達成しました。お祝いしますか？'
        ];
    }
    }

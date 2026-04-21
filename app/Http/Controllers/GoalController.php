<?php

namespace App\Http\Controllers;
use App\Models\Goal;
use App\Models\User;
use App\Notifications\GoalCompletedNotification;
use App\Notifications\MutualGoalCompletedNotification;
use App\Notifications\CelebrationReceivedNotification;
use Illuminate\Http\Request; 
class GoalController extends Controller
{
    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'target_value' => 'required|integer|min:1',
        ]);

        Goal::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'target_value' => $request->target_value,
            'current_value' => 0,
            'is_completed' => false,
        ]);

        return redirect()->route('dashboard')
            ->with('success', '目標を設定しました！🔥');
    }
    public function complete(Goal $goal)
    {
        if ($goal->user_id !== auth()->id()) {
            abort(403);
        }
    
        $goal->is_completed = true;
        $goal->save();
    
        $user = auth()->user();
    
        $user->notify(new GoalCompletedNotification($goal));
    
        $mutualUsers = $user->mutualFollows();
        
        \Log::info('complete() 実行 user_id: ' . $user->id);
        \Log::info('mutualUsers count: ' . $mutualUsers->count());
    
        foreach ($mutualUsers as $mutualUser) {
            \Log::info('通知送信 to: ' . $mutualUser->id);
            $mutualUser->notify(new MutualGoalCompletedNotification($goal));
        }
    
        return redirect()->route('dashboard')
            ->with('success', '目標達成おめでとうございます！🎉');
    }
    public function celebrate(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'goal_id' => 'required|exists:goals,id',
        ]);
    
        // 🎉 お祝い保存
        \App\Models\Celebration::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $request->to_user_id,
            'goal_id' => $request->goal_id,
            'stamp' => '🥂',
        ]);
    
        $goalOwner = \App\Models\User::findOrFail($request->to_user_id);
    
        // 🔔 相手に通知
        $goalOwner->notify(
            new \App\Notifications\CelebrationReceivedNotification(
                auth()->user(),
                $request->goal_id
            )
        );
    
        // ✅ 自分の通知を既読にする ← ⭐ここ追加
        $notification = auth()->user()
            ->notifications()
            // ->where('data->goal_id', $request->goal_id)
            ->whereRaw("data->>'goal_id' = ?", [(string) $request->goal_id])
            ->first();
    
        if ($notification) {
            $notification->markAsRead();
        }
    
        return back()->with('success', 'お祝いしました！🥂');
    }
        
}

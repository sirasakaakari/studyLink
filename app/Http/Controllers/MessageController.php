<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function show(User $user)
    {
        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $user->id);
        })
        ->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at')
        ->get();

        return view('dm.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $user)
    {
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'message' => $request->message,
            'stamp' => $request->stamp,
        ]);

        return redirect()->route('dm.show', $user->id);
    }
    public function update(Request $request, Message $message)
{
    // 自分のメッセージだけ編集可
    if ($message->sender_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'message' => 'required|string|max:500',
    ]);

    $message->update([
        'message' => $request->message,
    ]);

    return back();
}

public function destroy(Message $message)
{
    if ($message->sender_id !== auth()->id()) {
        abort(403);
    }

    $message->delete();

    return back();
}
}
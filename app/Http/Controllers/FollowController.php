<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FollowController extends Controller
{
    public function store(User $user)
{
    $authUser = Auth::user();

    if (!$authUser || $authUser->is_guest) {
        return redirect()->route('guest.register')
            ->with('error', 'フォローするには無料登録が必要です！');
    }

    if ($authUser->id === $user->id) {
        return back();
    }

    if (!$authUser->isFollowing($user->id)) {
        $authUser->followings()->attach($user->id);
    }

    return back();
}

public function followings()
{
    $user = auth()->user();

    $followings = $user->followings()
        ->where('is_guest', false)
        ->get();

    return view('followings.index', compact('followings'));
}

public function destroy(User $user)
{
    $authUser = Auth::user();

    if (!$authUser || $authUser->is_guest) {
        return redirect()->route('guest.register')
            ->with('error', 'フォロー解除には登録が必要です！');
    }

    $authUser->followings()->detach($user->id);

    return back();
}
}

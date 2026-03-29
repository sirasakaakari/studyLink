<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FollowController extends Controller
{
    // フォロー
    public function store(User $user)
    {
        $authUser = Auth::user();

        // 自分自身はフォロー不可
        if ($authUser->id === $user->id) {
            return back();
        }

        // すでにフォローしていなければ追加
        if (! $authUser->isFollowing($user->id)) {
            $authUser->followings()->attach($user->id);
        }

        return back();
    }
    // 自分がフォローしているユーザー一覧
    public function followings()
    {
        $user = auth()->user();
        $followings = $user->followings()->get(); // フォローしているユーザー

        return view('followings.index', compact('followings'));
    }


    // フォロー解除
    public function destroy(User $user)
    {
        $authUser = Auth::user();

        $authUser->followings()->detach($user->id);

        return back();
    }
}

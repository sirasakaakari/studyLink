<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // ユーザー一覧
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // ユーザープロフィール
    public function show(User $user)
    {
        // リレーションを読み込む
        $user->load([
            'supportsReceived.user', // ← これ追加
        ]);

        return view('users.show', compact('user'));
    }
}
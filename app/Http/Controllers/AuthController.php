<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function guestToRegister()
    {
        if (auth()->check() && auth()->user()->is_guest) {
        Auth::logout(); // ゲストならログアウト
    }

    return redirect()->route('register'); // 新規登録ページにリダイレクト
    }
    public function guestLogin()
    {
        $user = User::create([
            'name' => 'ゲスト',
            'email' => 'guest_' . Str::random(10) . '@example.com',
            'password' => bcrypt(Str::random(16)),
            'is_guest' => true,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
        
    }
}
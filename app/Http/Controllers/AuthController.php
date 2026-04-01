<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function guestLogin()
    {
        $user = User::create([
            'name' => 'ゲスト',
            'email' => 'guest_' . \Str::random(10) . '@example.com',
            'password' => bcrypt(\Str::random(16)),
            'is_guest' => true,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function guestToRegister()
    {
        $guestUser = auth()->user();

        if ($guestUser && $guestUser->is_guest) {
            Auth::logout();
            $guestUser->delete(); // ゲストユーザーをDBから削除
        }

        return redirect()->route('register');
    }
}
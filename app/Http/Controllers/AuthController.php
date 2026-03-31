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
            'email' => 'guest_' . Str::random(10) . '@example.com',
            'password' => bcrypt(Str::random(16)),
            'is_guest' => true,
        ]);

        Auth::login($user);

        return redirect('/home');
    }
}
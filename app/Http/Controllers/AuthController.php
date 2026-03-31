<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function guestLogin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => 'guest_' . Str::random(10) . '@example.com',
            'password' => bcrypt(Str::random(16)),
            'is_guest' => true,
        ]);

        Auth::login($user);

        return redirect('/home');
    }
}
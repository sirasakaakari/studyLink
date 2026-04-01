<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // ゲストユーザーを除外
        $users = User::where('id', '!=', Auth::id())
            ->where('is_guest', false)
            ->get();

        $recommendedUsers = User::where('id', '!=', Auth::id())
            ->where('is_guest', false)
            ->inRandomOrder()
            ->take(5)
            ->get();
        // dd($recommendedUsers); //

        $goals = Goal::where('user_id', Auth::id())->get();

        return view('dashboard', compact('users', 'recommendedUsers', 'goals'));
    }
}


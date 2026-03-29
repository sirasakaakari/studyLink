<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        $recommendedUsers = User::where('id', '!=', Auth::id())
            ->inRandomOrder()
            ->take(5)
            ->get();

        $goals = Goal::where('user_id', Auth::id())->get();

        return view('dashboard', compact(
            'users',
            'recommendedUsers',
            'goals'
        ));
    }
}


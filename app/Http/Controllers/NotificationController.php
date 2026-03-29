<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read($id)
    {
        $notification = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $notification->markAsRead();

        return back();
    }
}

// class NotificationController extends Controller
// {
//     public function read($id)
//     {
//         $notification = auth()->user()
//             ->notifications()
//             ->findOrFail($id);

//         $notification->markAsRead();

//         return back();
//     }
// }

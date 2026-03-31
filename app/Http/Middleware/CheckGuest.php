<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGuest
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_guest) {
            return redirect('/home')
                ->with('error', 'フォロー機能は登録ユーザーのみ利用できます');
        }

        return $next($request);
    }
}
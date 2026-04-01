<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // ゲストユーザーはログアウト時にDBから削除
        // User::booted() の cascade 処理も一緒に発火する
        Event::listen(Logout::class, function ($event) {
            if ($event->user && $event->user->is_guest) {
                $event->user->delete();
            }
        });
    }
}
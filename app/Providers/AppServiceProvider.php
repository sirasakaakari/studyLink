<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // 本番環境でis_guestカラムがなければ自動追加
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'is_guest')) {
            Schema::table('users', function ($table) {
                $table->boolean('is_guest')->default(false);
            });
        }

        // ゲストユーザーはログアウト時にDBから削除
        Event::listen(Logout::class, function ($event) {
            if ($event->user && $event->user->is_guest) {
                $event->user->delete();
            }
        });
    }
}
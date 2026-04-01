<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Event;
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

        // ビルド時はスキップ、実行時のみ実行
        if (app()->runningInConsole() && !app()->runningUnitTests()) {
            return;
        }

        try {
            // is_guestカラムがなければ自動追加
            if (Schema::hasTable('users') && !Schema::hasColumn('users', 'is_guest')) {
                Schema::table('users', function ($table) {
                    $table->boolean('is_guest')->default(false);
                });
            }
        } catch (\Exception $e) {
            // DB接続できない場合はスキップ
        }

        // ゲストユーザーはログアウト時にDBから削除
        Event::listen(Logout::class, function ($event) {
            if ($event->user && $event->user->is_guest) {
                $event->user->delete();
            }
        });
    }
}
{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-8 space-y-6 px-4">
    @if(auth()->check() && auth()->user()->is_guest)
    <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4 text-center">
        ゲストモードです。登録するとすべての機能が使えます。
        <a href="{{ route('guest.register') }}" class="underline ml-2 font-bold">
            登録する
        </a>
    </div>
@endif
@foreach($users as $user)
@endforeach
{{-- 学習リンク --}}
    <div class="card-pop">
        <h3 class="section-title">✨ 学習リンク</h3>
        <ul class="space-y-3">
            <li>
                <a href="{{ route('flashcards.index') }}" class="btn-pop btn-pink w-full block">
                    📚 単語学習（フラッシュカード）
                </a>
            </li>
            <li>
                <a href="{{ route('wordbooks.index') }}" class="btn-pop btn-yellow w-full block">
                    📖 マイ単語帳
                </a>
            </li>
            <li>
                <a href="{{ route('goals.create') }}" class="btn-pop btn-peach w-full block">
                    🎯 目標を設定する
                </a>
            </li>
            <li>
                @if(!auth()->user()->is_guest)
                    <a href="{{ route('profile.edit') }}" class="btn-pop btn-lavender w-full block">
                        🧸 プロフィール編集
                    </a>
                @else
                    <a href="{{ route('guest.register') }}" class="btn-pop btn-gray w-full block">
                        登録してプロフィール編集
                    </a>
                @endif
            </li>
            <li>
                @if(!auth()->user()->is_guest)
                    <a href="{{ route('followings.index') }}" class="btn-pop btn-mint w-full block">
                        👯 フォロー中ユーザー一覧
                    </a>
                @else
                    <a href="{{ route('guest.register') }}" class="btn-pop btn-gray w-full block">
                        登録してフォロー一覧を見る
                    </a>
                @endif
            </li>
        </ul>
    </div>

    {{-- 🔔 通知エリア --}}
    @if(auth()->user()->unreadNotifications->count())
        <div class="card-pop" style="border-color: #fde68a;">
            <h3 class="section-title">🔔 通知</h3>

            @foreach(auth()->user()->unreadNotifications as $notification)

                @if($notification->type === 'App\Notifications\MutualGoalCompletedNotification')
                    <div class="notif-card notif-yellow">
                        <p class="mb-3">{{ $notification->data['message'] }}</p>
                        <div class="flex gap-2">
                            <form action="{{ route('celebrate') }}" method="POST">
                                @csrf
                                <input type="hidden" name="goal_id" value="{{ $notification->data['goal_id'] }}">
                                <input type="hidden" name="to_user_id" value="{{ $notification->data['user_id'] }}">
                                <button class="btn-pop btn-mint" style="padding:6px 14px;font-size:0.8rem;">🥂 お祝いする</button>
                            </form>
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-pop btn-gray" style="padding:6px 14px;font-size:0.8rem;">✖</button>
                            </form>
                        </div>
                    </div>

                @elseif($notification->type === 'App\Notifications\GoalCompletedNotification')
                    <div class="notif-card notif-green">
                        <p class="mb-3">{{ $notification->data['message'] }}</p>
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-pop btn-gray" style="padding:6px 14px;font-size:0.8rem;">✖ 閉じる</button>
                        </form>
                    </div>

                @elseif($notification->type === 'App\Notifications\CelebrationReceivedNotification')
                    <div class="notif-card notif-blue">
                        <p class="mb-3">{{ $notification->data['message'] }}</p>
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-pop btn-gray" style="padding:6px 14px;font-size:0.8rem;">✖ 閉じる</button>
                        </form>
                    </div>
                @endif

            @endforeach
        </div>
    @endif

    {{-- 🔥 おすすめユーザー --}}
    <div class="card-pop">
        <h3 class="section-title">🔥 おすすめユーザー</h3>
        @forelse ($recommendedUsers as $user)
            @if(!$user->is_guest) {{-- 追加 --}}
            <div class="user-row">
                <div class="flex items-center gap-2">
                    <div class="avatar-bubble">{{ mb_substr($user->name, 0, 1) }}</div>
                    <span style="font-weight:700;color:#444;">{{ $user->name }}</span>
                </div>
                @if(!auth()->user()->is_guest)
                    @if (auth()->user()->isFollowing($user->id))
                        <form action="{{ route('follow.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn-pop btn-gray" style="padding:6px 14px;font-size:0.8rem;">
                                フォロー解除
                            </button>
                        </form>
                    @else
                        <form action="{{ route('follow.store', $user) }}" method="POST">
                            @csrf
                            <button class="btn-pop btn-pink" style="padding:6px 14px;font-size:0.8rem;">
                                ＋ フォロー
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('guest.register') }}"
                    class="btn-pop btn-gray"
                    style="padding:6px 14px;font-size:0.8rem;">
                        登録してフォロー
                    </a>
                @endif
            </div>
            @endif
        @empty
            <p style="color:#aaa;font-size:0.9rem;text-align:center;padding:16px 0;">おすすめユーザーはいません 🌸</p>
        @endforelse
    </div>
    {{-- 💛 応援したいユーザー --}}
<div class="card-pop">
    <h3 class="section-title">💛 応援したいユーザー</h3>
    @foreach($recommendedUsers as $user)
        @if(!$user->is_guest) {{-- 追加 --}}
        <div class="user-row">
            <div class="flex items-center gap-2">
                <div class="avatar-bubble avatar-yellow">{{ mb_substr($user->name, 0, 1) }}</div>
                <span style="font-weight:700;color:#444;">{{ $user->name }}</span>
            </div>
            @if(!auth()->user()->is_guest)
                <a href="{{ route('dm.show', $user->id) }}"
                class="btn-pop btn-yellow"
                style="padding:6px 14px;font-size:0.8rem;">
                    📣 応援する
                </a>
            @else
                <a href="{{ route('guest.register') }}"
                class="btn-pop btn-gray"
                style="padding:6px 14px;font-size:0.8rem;">
                    登録して応援
                </a>
            @endif
        </div>
        @endif
    @endforeach
</div>
    {{-- 🎯 目標一覧 --}}
@if($goals->count())
    <div class="card-pop">
        <h3 class="section-title">🎯 目標一覧</h3>
        @foreach($goals as $goal)
            <div class="user-row">
                <span style="font-weight:700;color:#444;">{{ $goal->title }}（{{ $goal->current_value }}/{{ $goal->target_value }}）</span>
                <form action="{{ route('goals.complete', $goal) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-pop btn-mint" style="padding:6px 14px;font-size:0.8rem;">
                        ✅ 達成！
                    </button>
                </form>
            </div>
        @endforeach
    </div>
@endif
</div>
@endsection

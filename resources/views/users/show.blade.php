@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-8">

    {{-- ユーザー名とフォロー情報 --}}
    <h1 class="text-xl font-bold mb-2">{{ $user->name }}</h1>

    <div class="flex gap-6 text-sm text-gray-600 mb-4">
        <div>
            <span class="font-bold text-black">{{ $user->followings()->count() }}</span> フォロー
        </div>
        <div>
            <span class="font-bold text-black">{{ $user->followers()->count() }}</span> フォロワー
        </div>
    </div>

    {{-- フォロー/フォロー解除ボタン --}}
    @if (Auth::id() !== $user->id)
        @if (Auth::user()->isFollowing($user->id))
            <form action="{{ route('follow.destroy', $user) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-gray-400 rounded">フォロー解除</button>
            </form>
        @else
            <form action="{{ route('follow.store', $user) }}" method="POST">
                @csrf
                <button class="px-4 py-2 bg-blue-500 text-white rounded">フォロー</button>
            </form>
        @endif
    @endif

    {{-- コメント・スタンプ送信フォーム --}}
    <div class="mt-6 p-4 border rounded">
        <h3 class="font-semibold mb-2">応援する</h3>
        <form action="{{ route('supports.store', $user) }}" method="POST">
            @csrf
            <input type="text" name="comment" placeholder="応援メッセージ" class="border px-2 py-1 rounded w-full mb-2">
            <button name="stamp" value="👍" type="submit" class="px-2 py-1 bg-blue-500 text-white rounded">👍</button>
            <button name="stamp" value="🎉" type="submit" class="px-2 py-1 bg-green-500 text-white rounded">🎉</button>
        </form>
    </div>

    {{-- 送られたコメント・スタンプ一覧 --}}
    <div class="mt-6">
        <h3 class="font-semibold mb-2">応援メッセージ一覧</h3>
        @forelse ($user->supportsReceived as $support)
            <div class="border-b py-2">
                <strong>{{ $support->user->name }}</strong>：
                {{ $support->comment ?? '' }}
                {{ $support->stamp ?? '' }}
            </div>
        @empty
            <p class="text-gray-500">まだ応援メッセージはありません</p>
        @endforelse
    </div>

</div>
@endsection

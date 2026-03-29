{{-- resources/views/users/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">
    <h1 class="text-xl font-bold mb-4">ユーザー一覧</h1>

    @foreach ($users as $user)
        <div class="flex items-center justify-between border-b py-3">
            {{-- ユーザー名（プロフィールへ） --}}
            <a href="{{ route('users.show', $user) }}" class="text-blue-600">
                {{ $user->name }}
            </a>

            {{-- 自分自身には表示しない --}}
            @if (Auth::id() !== $user->id)
                @if (Auth::user()->isFollowing($user->id))
                    <form action="{{ route('follow.destroy', $user) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 bg-gray-400 text-white rounded">
                            フォロー解除
                        </button>
                    </form>
                @else
                    <form action="{{ route('follow.store', $user) }}" method="POST">
                        @csrf
                        <button class="px-3 py-1 bg-blue-500 text-white rounded">
                            フォロー
                        </button>
                    </form>
                @endif
            @endif
        </div>
    @endforeach
</div>
@endsection

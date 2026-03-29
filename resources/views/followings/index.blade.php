@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8">

    <h2 class="text-2xl font-bold mb-4">あなたがフォローしているユーザー</h2>

    @forelse ($followings as $user)
        <div class="flex justify-between items-center border-b py-2">
            <span>{{ $user->name }}</span>

            <form action="{{ route('follow.destroy', $user) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="px-3 py-1 bg-gray-400 rounded">
                    フォロー解除
                </button>
            </form>
        </div>
    @empty
        <p class="text-gray-500">現在フォローしているユーザーはいません</p>
    @endforelse

</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8 p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">応援する: {{ $user->name }}</h1>

    <form action="{{ route('supports.store', $user) }}" method="POST">
        @csrf
        <input type="text" name="comment" placeholder="応援メッセージ" class="border p-2 w-full mb-2">
        <div class="flex gap-2 mb-2">
            <button name="stamp" value="👍" class="px-3 py-1 bg-gray-200 rounded">👍</button>
            <button name="stamp" value="🎉" class="px-3 py-1 bg-gray-200 rounded">🎉</button>
            <button name="stamp" value="💪" class="px-3 py-1 bg-gray-200 rounded">💪</button>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">送信</button>
    </form>
</div>
@endsection

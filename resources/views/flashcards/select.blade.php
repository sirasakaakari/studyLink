@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">使う単語帳を選択</h2>

<form method="POST" action="{{ route('flashcards.start') }}">
    @csrf

    <div class="space-y-2 mb-4">
        @foreach ($wordbooks as $wordbook)
            <label class="flex items-center space-x-2">
                <input
                    type="checkbox"
                    name="wordbooks[]"
                    value="{{ $wordbook->id }}"
                    class="rounded"
                >
                <span>{{ $wordbook->name }}</span>
            </label>
        @endforeach
    </div>

    <button class="px-4 py-2 bg-blue-500 text-white rounded">
        フラッシュカード開始
    </button>
</form>
@endsection

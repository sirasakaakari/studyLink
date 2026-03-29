@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto text-center">

    <h2 class="text-xl font-semibold mb-4">
        StudyLink Vocabulary
    </h2>

    <div class="mb-4">
        <a href="{{ route('wordbooks.create') }}"
           class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            自分専用の単語帳を作成
        </a>
    </div>

    {{-- 単語 --}}
    <h2 class="text-2xl font-bold mb-6">
        {{ $word->word }}
    </h2>

    {{-- 進捗 --}}
    @if(isset($progress))
        <div class="mb-4 text-gray-700">
            問題 {{ $progress['current'] }} / {{ $progress['total'] }}
            ・ 正解 {{ $progress['correct'] }}
        </div>
    @endif

    {{-- 正誤表示 --}}
    @if(session('result'))
        <div class="mb-6 p-4 rounded
            {{ session('result') === 'correct' ? 'bg-green-100' : 'bg-red-100' }}">
            {{ session('result') === 'correct' ? '🎉 正解！' : '😢 不正解…' }}

            @if(session('result') === 'wrong')
                <div class="mt-2 text-sm">
                    正解：<strong>{{ session('answer') }}</strong><br>
                    あなたの選択：<strong>{{ session('selected') }}</strong>
                </div>
            @endif
        </div>
    @endif

    {{-- 回答 --}}
    <form method="POST" action="{{ route('flashcards.answer') }}">
        @csrf
        <input type="hidden" name="word_id" value="{{ $word->id }}">

        @foreach($choices as $choice)
            <button type="submit"
                    name="selected"
                    value="{{ $choice }}"
                    class="block w-full mb-3 p-3 border rounded hover:bg-gray-100">
                {{ $choice }}
            </button>
        @endforeach
    </form>

    {{-- 次へ --}}
    @if(session('result'))
        <div class="mt-6">
            <a href="{{ route('flashcards.next') }}"
               class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                次の単語へ ▶
            </a>
        </div>
    @endif

</div>
@endsection

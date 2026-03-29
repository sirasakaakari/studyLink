@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-4">
        {{ $wordbook->title }}
    </h1>

    {{-- 単語追加フォーム --}}
    <form method="POST" action="{{ route('wordbooks.words.store', $wordbook) }}" class="mb-6">
        @csrf

        <div class="flex gap-2">
            <input
                type="text"
                name="word"
                placeholder="単語"
                class="border p-2 w-1/3"
            >
            <input
                type="text"
                name="meaning"
                placeholder="意味"
                class="border p-2 w-2/3"
            >
            <button class="bg-blue-500 text-white px-4">
                追加
            </button>
        </div>
    </form>

    {{-- 単語一覧 --}}
    <table class="w-full border">
        <tr class="bg-gray-100">
            <th class="border p-2">単語</th>
            <th class="border p-2">意味</th>
        </tr>

        @foreach ($words as $word)
        <tr>
            <td class="border p-2">{{ $word->word }}</td>
            <td class="border p-2">{{ $word->meaning }}</td>
        </tr>
        @endforeach
    </table>

</div>
@endsection

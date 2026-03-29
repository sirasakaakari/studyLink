@extends('layouts.app')

@section('content')
    <h2 class="text-xl font-bold mb-4">自分の単語帳一覧</h2>

    <a
        href="{{ route('wordbooks.create') }}"
        class="inline-block mb-4 px-4 py-2 bg-blue-500 text-white rounded"
    >
        新しい単語帳を作成
    </a>

    <div class="space-y-2">
        @foreach ($wordbooks as $wordbook)
            <a
                href="{{ route('wordbooks.show', $wordbook) }}"
                class="block border bg-white p-4 rounded shadow hover:bg-gray-50 text-gray-900"
            >
                {{ $wordbook->name }}
            </a>
        @endforeach
    </div>
@endsection

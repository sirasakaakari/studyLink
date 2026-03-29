@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-8">
    <h1 class="text-xl font-bold mb-4">🎯 学習目標を設定</h1>

    <form method="POST" action="{{ route('goals.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">目標内容</label>
            <input type="text" name="title" class="w-full border p-2"
                   placeholder="例：1日10単語正解する">
        </div>

        <div class="mb-4">
            <label class="block mb-1">目標数値</label>
            <input type="number" name="target_value" class="w-full border p-2"
                   placeholder="10">
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            目標を作成
        </button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 shadow">
    <h1 class="text-xl font-bold mb-4">新しい単語帳を作成</h1>

    <form method="POST" action="{{ route('wordbooks.store') }}">
        @csrf

        <input
            type="text"
            name="name"
            class="w-full border p-2 mb-4"
            placeholder="単語帳の名前"
            required
        >

        <button class="bg-blue-500 text-white px-4 py-2">
            作成
        </button>
    </form>
</div>
@endsection

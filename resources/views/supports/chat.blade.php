@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">

    <h2 class="text-xl font-bold mb-4">
        {{ $user->name }} とのチャット
    </h2>

    <div class="border p-4 h-96 overflow-y-scroll mb-4 bg-white">

        @foreach($supports as $support)

            @if($support->user_id === auth()->id())
                <div class="text-right mb-2">
                    <div class="inline-block bg-blue-500 text-white px-3 py-2 rounded">
                        {{ $support->comment ?? $support->stamp }}
                    </div>
                </div>
            @else
                <div class="text-left mb-2">
                    <div class="inline-block bg-gray-300 px-3 py-2 rounded">
                        {{ $support->comment ?? $support->stamp }}
                    </div>
                </div>
            @endif

        @endforeach

    </div>

    <form action="{{ route('supports.store', $user) }}" method="POST">
        @csrf
        <input type="text" name="comment" class="border p-2 w-full mb-2">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
            送信
        </button>
    </form>

</div>
@endsection
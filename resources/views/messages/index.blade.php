@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-8">

<h2 class="text-xl font-bold mb-4">DM一覧</h2>

@foreach($messages as $message)

@php
$partner = $message->sender_id === auth()->id()
    ? $message->receiver
    : $message->sender;
@endphp

<div class="border p-3 mb-2 bg-white rounded">
    <a href="{{ route('messages.chat', $partner) }}">
        {{ $partner->name }}
    </a>
</div>

@endforeach

</div>
@endsection
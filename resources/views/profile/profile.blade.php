@extends('layouts.app')

@section('content')
<h2>プロフィール</h2>

<p>フォロワー数：{{ $followersCount }}</p>
<p>フォロー数：{{ $followingCount }}</p>
@endsection

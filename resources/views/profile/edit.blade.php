@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8 space-y-6">

    <h2 class="text-2xl font-bold mb-4">プロフィール</h2>

    {{-- ログインユーザー情報 --}}
    <div class="mb-4 text-gray-700">
        <p>名前: {{ $user->name }}</p>
        <p>メール: {{ $user->email }}</p>
    </div>

    {{-- フォロー情報 --}}
    <div class="p-4 bg-white shadow rounded mb-6">
        <h3 class="text-lg font-semibold mb-2">フォロー情報</h3>
        <div class="flex gap-6">
            <div>
                <span class="font-bold">{{ $user->followings()->count() }}</span> フォロー
            </div>
            <div>
                <span class="font-bold">{{ $user->followers()->count() }}</span> フォロワー
            </div>
        </div>
    </div>

    {{-- フォローボタン（自分以外のユーザーを表示する場合） --}}
    @if(isset($profileUser) && $profileUser->id !== $user->id)
    <div class="mb-6">
        @if($user->isFollowing($profileUser->id))
            <form action="{{ route('follow.destroy', $profileUser) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-gray-400 text-white rounded">フォロー解除</button>
            </form>
        @else
            <form action="{{ route('follow.store', $profileUser) }}" method="POST">
                @csrf
                <button class="px-4 py-2 bg-blue-500 text-white rounded">フォロー</button>
            </form>
        @endif
    </div>
    @endif

    {{-- プロフィール編集フォーム --}}
    <div class="p-4 bg-white shadow rounded">
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- パスワード変更フォーム --}}
    <div class="p-4 bg-white shadow rounded">
        @include('profile.partials.update-password-form')
    </div>

    {{-- 退会フォーム --}}
    <div class="p-4 bg-white shadow rounded">
        @include('profile.partials.delete-user-form')
    </div>

</div>
@endsection

<!-- Logo -->
<a href="{{ route('flashcards.start') }}">
    <x-application-logo />
</a>

<!-- ナビリンク -->
<div>
    <a href="{{ route('flashcards.start') }}">単語学習</a>
</div>

@auth
    <!-- ログイン時 -->
    <div>
        {{ Auth::user()->name }}
    </div>

    <a href="{{ route('dashboard') }}">Dashboard</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button>ログアウト</button>
    </form>
@endauth

@guest
    <!-- ゲスト時 -->
    <a href="{{ route('login') }}">ログイン</a>
    <a href="{{ route('register') }}">新規登録</a>
@endguest

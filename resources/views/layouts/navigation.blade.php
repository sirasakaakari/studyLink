<div class="flex justify-between h-16">
    <!-- 左側：ロゴ + ナビ -->
    <div class="flex">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        </a>

        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <a href="{{ route('dashboard') }}"
               class="text-sm font-medium text-gray-700 hover:text-blue-600">
                Home
            </a>

            <a href="{{ route('flashcards.select') }}"
               class="text-sm font-medium text-gray-700 hover:text-blue-600">
                単語学習
            </a>

            @auth
                <a href="{{ route('wordbooks.index') }}"
                   class="text-sm font-medium text-gray-700 hover:text-blue-600">
                    My単語帳
                </a>
            @endauth
        </div>
    </div>

    <!-- 右側：ユーザーメニュー -->
    @auth
    <div class="hidden sm:flex sm:items-center sm:ms-6">
        <x-dropdown align="right" width="48">
            <!-- <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 text-sm font-medium
                               rounded-md text-gray-500 bg-white hover:text-gray-700">
                    {{ Auth::user()->name }}
                </button>
            </x-slot> -->
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 text-sm font-medium
                            rounded-md text-gray-500 bg-white hover:text-gray-700">

                    @if(auth()->user()->is_guest)
                        <span class="text-yellow-500 font-bold">
                            ゲストモード
                        </span>
                    @else
                        {{ Auth::user()->name }}
                    @endif

                </button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    プロフィール
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        ログアウト
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
    @endauth

    {{-- ゲスト --}}
    @if(auth()->check() && auth()->user()->is_guest)
        <div class="hidden sm:flex sm:items-center sm:ms-6 gap-4">
            <a href="{{ route('register') }}" class="underline text-sm">
                登録
            </a>
            <a href="{{ route('login') }}" class="underline text-sm">
                ログイン
            </a>
        </div>
    @endif

    {{-- 未ログイン --}}
    @guest
        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <a href="{{ route('login') }}" class="underline text-sm">ログイン</a>
            <a href="{{ route('register') }}" class="underline text-sm ms-4">新規登録</a>
        </div>
    @endguest
    <!-- <div class="hidden sm:flex sm:items-center sm:ms-6">
        <a href="{{ route('login') }}" class="underline text-sm">ログイン</a>
        <a href="{{ route('register') }}" class="underline text-sm ms-4">新規登録</a>
    </div> -->
</div>

@if (Auth::id() !== $user->id)

    @auth
        @if(!auth()->user()->is_guest)

            {{-- 通常ユーザー --}}
            @if (Auth::user()->isFollowing($user->id))
                <form action="{{ route('follow.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 bg-gray-400 text-white rounded">
                        フォロー解除
                    </button>
                </form>
            @else
                <form action="{{ route('follow.store', $user) }}" method="POST">
                    @csrf
                    <button class="px-3 py-1 bg-blue-500 text-white rounded">
                        フォロー
                    </button>
                </form>
            @endif

        @else

            {{-- ゲストユーザー --}}
            <a href="{{ route('register') }}"
               class="px-3 py-1 bg-gray-400 text-white rounded">
                登録してフォロー
            </a>

        @endif
    @endauth

@endif
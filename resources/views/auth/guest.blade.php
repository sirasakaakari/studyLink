<x-guest-layout>

    <form method="POST" action="/guest-login">
        @csrf

        <!-- タイトル -->
        <div class="mb-4 text-center">
            <h2 class="text-lg font-bold">ゲストで学習する</h2>
        </div>

        <!-- 名前入力 -->
        <div>
            <x-input-label for="name" :value="__('ユーザ名')" />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
            />

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- ボタン -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                始める
            </x-primary-button>
        </div>

    </form>

</x-guest-layout>
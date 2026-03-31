<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>StudyLink Vocabulary</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<div class="min-h-screen flex flex-col justify-center items-center gap-6">

    <h1 class="text-4xl font-bold">
        StudyLink Vocabulary
    </h1>

    <p class="text-lg">
        単語学習を、ひとりじゃなく。
    </p>

    @auth
        <a href="/flashcards"
           class="px-6 py-3 bg-blue-600 text-white rounded">
            単語学習を始める
        </a>
    @else
        <div class="flex gap-4">
            <a href="{{ route('login') }}"
               class="px-5 py-2 bg-green-600 text-white rounded">
                ログイン
            </a>

            <a href="{{ route('register') }}"
               class="px-5 py-2 bg-blue-600 text-white rounded">
                新規登録
            </a>
        </div>
        <a href="/guest" class="underline text-sm">
            ゲストで学習する
        </a>
    @endauth

</div>

</body>
</html>

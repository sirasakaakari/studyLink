{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Google Fonts --}}
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
 -->
    {{-- Vite: app.css + dashboard.css + app.js --}}
    @vite(['resources/css/app.css', 'resources/css/common.css', 'resources/js/app.js'])
</head>
<body>
<div class="min-h-screen">

    @include('layouts.navigation')

    @isset($header)
        <header class="page-header">
            <div class="max-w-7xl mx-auto">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main class="max-w-7xl mx-auto p-6">
        @yield('content')
    </main>

</div>
</body>
</html>

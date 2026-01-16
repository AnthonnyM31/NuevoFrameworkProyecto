<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light font-sans antialiased">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center pt-3 PTC-sm-0">
        <div class="mb-4">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-secondary" />
            </a>
        </div>

        <div class="w-100 sm:max-w-md mt-3 px-4 py-4 bg-white shadow rounded-lg" style="max-width: 500px;">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
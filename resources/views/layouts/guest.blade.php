<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Bookish Space') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <x-fonts />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
        <div class="font-sans text-gray-900">
            {{ $slot }}
        </div>
    </body>
</html>

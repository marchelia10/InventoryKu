<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'App Peminjaman') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-cover bg-center flex justify-end items-center p-2 sm:p-6" style="background-image: url('{{ asset('images/bg-auth.png') }}');">            
            <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 lg:mr-2">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

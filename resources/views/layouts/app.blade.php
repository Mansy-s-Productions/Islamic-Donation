<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'IslamHouse') }}</title>
        <link rel="icon" href="{{url('public/img/logo.png')}}">
        @stack('head')
        <!-- font awesome -->
        <link href="{{url('public/css/all.min.css')}}" rel="stylesheet">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{url('public/css/flowbite-1.6.5.min.css')}}" />
        {{-- Css --}}
        <link href="{{url('public/css/admin.css')}}" rel="stylesheet">

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <!-- Page Content -->
        <main>
                {{ $slot }}
            </main>
        </div>
        {{-- Flowbite Js --}}
        <script src="{{url('public/js/flowbite-1.6.5.min.js')}}"></script>
        {{-- Font Awesome --}}
        <script src="{{url('public/js/all.min.js')}}"></script>
        {{-- PopperJs --}}
        <script src="{{url('public/js/popper.min.js')}}"></script>
        {{-- FancyBox --}}
        @stack('other-scripts')
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/custom.js'])
    </body>
</html>

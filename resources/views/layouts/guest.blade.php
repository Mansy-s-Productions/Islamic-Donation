<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'IslamHouse') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="{{url('public/css/all.min.css')}}" rel="stylesheet">

        <link href="{{url('public/css/admin.css')}}" rel="stylesheet">
        <!-- Css -->
        <link href="{{url('/build/assets/app-2db575ce.css')}}" rel="stylesheet">
        <link href="{{url('/build/assets/app-74930efa.css')}}" rel="stylesheet">
        <link href="{{url('/build/assets/custom-a792a0dd.css')}}" rel="stylesheet">
        <!-- Scripts -->
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <img width="100" src="{{ url('public/img/logo.png') }}" />
                </a>
            </div>
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        <script src="{{url('public/js/all.min.js')}}"></script>
        <script src="{{url('/build/assets/app-1455c32c.js')}}"></script>
        <script src="{{url('/build/assets/custom-7301d4ed.js')}}"></script>

        {{-- @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/custom.js']) --}}


    </body>
</html>

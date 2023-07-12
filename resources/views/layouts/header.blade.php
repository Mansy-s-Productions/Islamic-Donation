<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>IslamHouse</title>

        <link rel="icon" href="{{url('public/img/logo.png')}}">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{url('public/css/bootstrap.rtl.min.css')}}">
        <link href="{{url('public/css/datatables.min.css')}}" rel="stylesheet"/>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
        <!-- font awesome -->
        {{-- Fontawesome --}}
        <link href="{{url('public/css/all.min.css')}}" rel="stylesheet">
        <!-- Css -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{url('public/css/app.css')}}" rel="stylesheet">
        @vite(['resources/scss/app.scss' ,'resources/js/app.js'])
    </head>

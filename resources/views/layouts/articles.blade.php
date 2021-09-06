<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>@yield('title')</title>
</head>
<body>
@if(session()->has('notice'))
    <div class="errors p-3 bg-green-400 text-green-50 rounded fixed top-0 w-full flex justify-between items-center" id="msg-box">
        <div class="font-bold text-base font-sans m-1">{{ session('notice') }}</div>
        <x-fontisto-close class="w-6 h-6" />
    </div>
@endif
@yield('main')
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/articles.js') }}"></script>
@yield('js')
</html>

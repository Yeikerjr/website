<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title')</title>

    <!-- Here we add Roboto Font of Google -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" id="fontsGoogle">

    <!-- Here we use fontawesome 5.15.1 -->
    <script src="{{ asset('js/allFontAwesome.js') }}"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">

    <livewire:styles />

    @yield('custom_css')

</head>
<body>

    <livewire:header />


    @yield('content')


    <livewire:footer />

    <livewire:scripts />
    <script src="{{ asset('js/main.js') }}"></script>
    @yield('custom_js')
</body>
</html>

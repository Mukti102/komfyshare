<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- logo dan favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('storage/' . setting('general.logo')) }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/' . setting('general.favicon')) }}">

    {{-- Logo untuk share (Open Graph & Twitter) --}}
    <meta property="og:title" content="{{ setting('seo.title') }}">
    <meta property="og:description" content="{{ setting('seo.description') }}">
    <meta property="og:image" content="{{ asset('storage/' . setting('general.logo')) }}">

    <title>
        @hasSection('title')
            @yield('title')
        @else
            {{ setting('seo.title') }}
        @endif
    </title>

    <meta name="description" content="{{ setting('seo.description') }}">

    <link rel="icon" href="" type="image/png">
    @livewireStyles
    @include('includes.styles')
    @stack('styles')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 bg-gray-50 antialiased">
    @include('partials.navbar')

   

    <div>
        <x-alert />
        @yield('content')
    </div>

    <x-popup-support/>

    @include('partials.footer')
    @include('sweetalert::alert')

    <!-- FIXED: Load includes.scripts first, then livewire -->
    @include('includes.scripts')
    @stack('scripts')
    @livewireScripts

</body>

</html>

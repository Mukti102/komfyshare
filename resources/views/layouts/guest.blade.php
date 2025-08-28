<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') </title>
    <meta name="description" content="securely share your files with ease.">

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
        @yield('content')
    </div>
    <!-- Back to Top Button -->
    <button id="backToTop"
        class="fixed bottom-8 z-[10000] right-8 bg-primary text-white p-3 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all opacity-0 invisible">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    @include('partials.footer')
    @livewireScripts
</body>
@include('includes.scripts')
@stack('scripts')

{{-- @include('sweetalert::alert') --}}

</html>

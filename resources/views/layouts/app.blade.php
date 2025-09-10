<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGEDRA - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts y Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-sigedra-bg font-sans text-sigedra-text-dark antialiased text-base">

<!-- ========== HEADER ========== -->
@include('layouts.partials.header')

<!-- ========== SIDEBAR ========== -->
@include('layouts.partials.sidebar')

<!-- ========== MAIN CONTENT ========== -->
<div class="w-full lg:ps-64">
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24">
        @yield('content')
    </main>
</div>
<!-- ========== END MAIN CONTENT ========== -->

@livewireScripts
<script>
    document.addEventListener('livewire:navigated', () => {
        setTimeout(() => {
            window.HSStaticMethods.autoInit();
        }, 100);
    });
</script>
</body>
</html>

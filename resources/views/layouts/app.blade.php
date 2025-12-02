<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>@yield('title', 'App')</title>

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-[#F7F7F7] text-[#333333] font-sans antialiased pb-24">

    {{-- Navbar --}}
    @includeIf('component.navbar')

    <main class="w-full max-w-[480px] mx-auto min-h-screen relative">
        @yield('content')
    </main>

    {{-- Bottom Nav --}}
    {{-- Tampilkan Bottom Nav KECUALI di halaman create & edit --}}
    @if(!request()->routeIs('menu.create') && !request()->routeIs('menu.edit'))
        @includeIf('component.bottom-nav')
    @endif

    {{-- Scripts --}}
    @vite(['resources/js/menu.js'])
    @stack('scripts')

</body>
</html>
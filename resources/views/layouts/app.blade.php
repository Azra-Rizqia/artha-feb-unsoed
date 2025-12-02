<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>@yield('title', 'App')</title>

    {{-- Global CSS --}}
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    @stack('styles')
</head>

<body class="app-container">

    @includeIf('components.navbar')

    <main class="page-content">
        @yield('content')
    </main>

    @includeIf('components.bottom-nav')

    {{-- Global JS --}}
    <script src="{{ asset('js/menu.js') }}"></script>
    @stack('scripts')

</body>
</html>

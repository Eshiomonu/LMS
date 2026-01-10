<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', config('app.name', 'AsproHubs'))
    </title>

    <meta name="description" content="@yield('meta_description', 'Professional training and e-learning platform')">
    link

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    {{-- Global Navigation --}}
    <x-navbar />

    {{-- Page Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer (optional global footer later) --}}
    {{-- <x-footer /> --}}

</body>
</html>

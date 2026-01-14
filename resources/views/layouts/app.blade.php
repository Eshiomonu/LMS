<!DOCTYPE html>
<html lang="en">
<head>
    {{-- Basic Meta --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Title --}}
    <title>@yield('title', config('app.name', 'AsproHubs'))</title>

    {{-- SEO Meta --}}
    <meta name="description"
          content="@yield('meta_description', 'AsproHubs is a professional learning platform offering industry-grade courses for individuals and organizations.')">

    <meta name="keywords"
          content="@yield('meta_keywords', 'online courses, professional training, tech skills, AsproHubs')">

    <meta name="author" content="AsproHubs">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('meta_image', asset('images/og-image.png'))">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('app.name'))">
    <meta name="twitter:description" content="@yield('meta_description')">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/og-image.png'))">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 antialiased flex flex-col min-h-screen">

    {{-- Navbar --}}
    <x-navbar />

    {{-- Page Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-footer />

</body>
</html>

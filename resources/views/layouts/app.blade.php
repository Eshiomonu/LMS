<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'AsproHubs — Professional Learning Platform')</title>
    <meta name="description" content="@yield('meta_description', 'Expert-led professional courses on AsproHubs.')">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600&display=swap" rel="stylesheet" />

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ── Brand CSS variables — used across ALL blades ── */
        :root {
            --aspro-primary:        #4f46e5;
            --aspro-primary-dark:   #4338ca;
            --aspro-primary-light:  #e0e7ff;
            --aspro-dark:           #0f172a;
            --aspro-light:          #f8fafc;
            --aspro-border:         #e2e8f0;
        }

        * { font-family: 'DM Sans', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Syne', sans-serif; }
        [x-cloak] { display: none !important; }

        /* Tailwind can't resolve var() at compile time, so we add helpers */
        .text-aspro-primary  { color: var(--aspro-primary); }
        .bg-aspro-primary    { background-color: var(--aspro-primary); }
        .border-aspro-primary { border-color: var(--aspro-primary); }
    </style>

    @stack('styles')
</head>
<body class="bg-white text-gray-900 antialiased">

    @include('layouts.navbar')

    {{-- ── Toast notifications (auto-dismiss) ── --}}
    @foreach(['success' => 'emerald', 'error' => 'red', 'info' => 'blue'] as $type => $color)
        @if(session($type))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="fixed top-4 right-4 z-50 max-w-sm w-full rounded-2xl border
                   border-{{ $color }}-200 bg-{{ $color }}-50 px-5 py-4 shadow-xl
                   flex items-start gap-3 text-sm text-{{ $color }}-800"
        >
            <svg class="h-5 w-5 flex-shrink-0 mt-0.5 text-{{ $color }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                @if($type === 'success')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                @elseif($type === 'error')
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                @else
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                @endif
            </svg>
            <p class="flex-1">{{ session($type) }}</p>
            <button @click="show = false" class="text-{{ $color }}-400 hover:text-{{ $color }}-600 ml-auto flex-shrink-0">✕</button>
        </div>
        @endif
    @endforeach

    {{-- Page content --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="bg-[var(--aspro-dark)] text-slate-400 py-14 mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">

                {{-- Brand --}}
                <div>
                    <p class="font-bold text-white text-xl" style="font-family:'Syne',sans-serif;">AsproHubs</p>
                    <p class="text-sm mt-1 text-slate-500">Professional Learning Platform</p>
                </div>

                {{-- Links --}}
                <div class="flex gap-8 text-sm">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                    <a href="{{ route('courses.index') }}" class="hover:text-white transition">Courses</a>
                    @guest
                        <a href="{{ route('login') }}" class="hover:text-white transition">Sign In</a>
                        <a href="{{ route('register') }}" class="hover:text-white transition">Register</a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="hover:text-white transition">Dashboard</a>
                    @endguest
                </div>

                <p class="text-xs text-slate-600">© {{ date('Y') }} AsproHubs. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>@yield('title', 'Dashboard') | AsproHubs</title>

    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --aspro-primary:       #4f46e5;
            --aspro-primary-dark:  #4338ca;
            --aspro-primary-light: #e0e7ff;
            --aspro-dark:          #0f172a;
            --aspro-light:         #f8fafc;
            --aspro-border:        #e2e8f0;
        }
        *, body { font-family: 'DM Sans', sans-serif; }
        h1,h2,h3,h4 { font-family: 'Syne', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 antialiased" x-data="{ sidebarOpen: false }">

{{-- Mobile overlay --}}
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
     class="fixed inset-0 z-20 bg-black/40 lg:hidden"></div>

{{-- ══ SIDEBAR ══ --}}
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-white
              border-r border-slate-200 shadow-xl
              transition-transform duration-300 lg:translate-x-0">

    {{-- Logo --}}
    <div class="flex h-16 items-center gap-3 border-b border-slate-100 px-5 flex-shrink-0">
        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg"
             style="background:var(--aspro-primary)">
            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <span class="font-extrabold text-slate-900 text-lg" style="font-family:'Syne',sans-serif;">
            AsproHubs
        </span>
    </div>

    {{-- User badge --}}
    <div class="mx-3 mt-4 mb-1 rounded-xl bg-slate-50 px-3 py-3 flex items-center gap-3">
        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
             class="h-9 w-9 rounded-full object-cover border-2 border-white shadow flex-shrink-0"/>
        <div class="min-w-0">
            <p class="truncate text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
            <p class="text-xs text-slate-400">Student</p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-2 space-y-0.5">

        <p class="px-3 pt-3 pb-1 text-[10px] font-bold uppercase tracking-widest text-slate-400">Main</p>

        <a href="{{ route('student.dashboard') }}"
           class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-sm font-medium transition
                  {{ request()->routeIs('student.dashboard') ? 'font-bold text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           style="{{ request()->routeIs('student.dashboard') ? 'background:var(--aspro-primary)' : '' }}">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('student.enrollments.index') }}"
           class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-sm font-medium transition
                  {{ request()->routeIs('student.enrollments.*') ? 'font-bold text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           style="{{ request()->routeIs('student.enrollments.*') ? 'background:var(--aspro-primary)' : '' }}">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            My Enrollments
        </a>

        <a href="{{ route('courses.index') }}"
           class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-sm font-medium
                  text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Browse Courses
        </a>

        <p class="px-3 pt-4 pb-1 text-[10px] font-bold uppercase tracking-widest text-slate-400">Account</p>

        <a href="{{ route('student.profile.edit') }}"
           class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-sm font-medium transition
                  {{ request()->routeIs('student.profile.*') ? 'font-bold text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           style="{{ request()->routeIs('student.profile.*') ? 'background:var(--aspro-primary)' : '' }}">
            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Profile Settings
        </a>

    </nav>

    {{-- Sign out --}}
    <div class="flex-shrink-0 border-t border-slate-100 p-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2.5 text-sm font-medium
                           text-red-500 hover:bg-red-50 hover:text-red-600 transition">
                <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>

{{-- ══ MAIN ══ --}}
<div class="lg:pl-64 flex min-h-screen flex-col">

    {{-- Top bar --}}
    <header class="sticky top-0 z-10 flex h-16 items-center justify-between
                   border-b border-slate-200 bg-white px-5 shadow-sm flex-shrink-0">
        <div class="flex items-center gap-3">
            {{-- Mobile hamburger --}}
            <button @click="sidebarOpen = true"
                    class="lg:hidden flex h-9 w-9 items-center justify-center
                           rounded-lg text-slate-500 hover:bg-slate-100 transition">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <h1 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                @yield('page-title', 'Dashboard')
            </h1>
        </div>

        <div class="flex items-center gap-3" x-data="{ open: false }">
            <a href="{{ route('courses.index') }}"
               class="hidden sm:inline-flex items-center gap-1.5 rounded-xl px-4 py-2
                      text-xs font-bold text-white transition"
               style="background:var(--aspro-primary)">
                Browse Courses
            </a>

            <button @click="open = !open" class="relative">
                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}"
                     class="h-9 w-9 rounded-full object-cover border-2 border-slate-200
                            hover:border-[var(--aspro-primary)] transition"/>
            </button>

            <div x-show="open" x-cloak @click.outside="open = false"
                 class="absolute right-4 top-14 z-50 w-52 rounded-2xl border border-slate-100
                        bg-white shadow-xl overflow-hidden py-1">
                <div class="border-b border-slate-100 px-4 py-3">
                    <p class="truncate text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('student.dashboard') }}"
                   class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700
                          hover:bg-indigo-50 hover:text-indigo-700 transition">Dashboard</a>
                <a href="{{ route('student.profile.edit') }}"
                   class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700
                          hover:bg-indigo-50 hover:text-indigo-700 transition">Profile Settings</a>
                <div class="border-t border-slate-100 mt-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center gap-2 px-4 py-2.5 text-sm
                                       text-red-600 hover:bg-red-50 transition">Sign Out</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- Flash toasts --}}
    @foreach(['success' => 'emerald', 'error' => 'red', 'info' => 'blue'] as $type => $color)
        @if(session($type))
        <div x-data="{ show: true }" x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             class="fixed top-4 right-4 z-50 max-w-sm w-full rounded-2xl border
                    border-{{ $color }}-200 bg-{{ $color }}-50 px-5 py-4 shadow-xl
                    flex items-start gap-3 text-sm text-{{ $color }}-800">
            <p class="flex-1">{{ session($type) }}</p>
            <button @click="show = false" class="text-{{ $color }}-400 hover:text-{{ $color }}-600">✕</button>
        </div>
        @endif
    @endforeach

    {{-- Content --}}
    <main class="flex-1 p-5 sm:p-8">
        @yield('content')
    </main>

</div>

@stack('scripts')
</body>
</html>
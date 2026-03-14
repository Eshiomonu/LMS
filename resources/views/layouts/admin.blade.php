<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Admin') — AsproHubs</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            --brand:        #4f46e5;
            --brand-dark:   #3730a3;
            --brand-light:  #e0e7ff;
            --sidebar-bg:   #0c1220;
            --sidebar-item: rgba(255,255,255,0.05);
            --sidebar-text: #7c8fa6;
            --sidebar-w:    256px;
        }

        * { font-family: 'DM Sans', sans-serif; }
        [x-cloak] { display: none !important; }

        /* ── Sidebar nav items ── */
        .nav-link {
            display: flex; align-items: center; gap: 10px;
            padding: 8px 11px; border-radius: 9px;
            font-size: 13.5px; font-weight: 500;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: background .15s, color .15s;
        }
        .nav-link:hover  { background: rgba(255,255,255,.07); color: #e2e8f0; }
        .nav-link.active { background: var(--brand); color: #fff; font-weight: 700; }
        .nav-link svg    { flex-shrink: 0; width: 16px; height: 16px; }

        .nav-group-label {
            padding: 14px 11px 5px;
            font-size: 10px; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: #2d3f55;
        }

        /* ── Badge pill ── */
        .badge-pill {
            margin-left: auto;
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 20px; height: 20px; padding: 0 5px;
            border-radius: 999px;
            font-size: 10px; font-weight: 700; line-height: 1;
        }

        /* ── Stat card hover line ── */
        .stat-card { position: relative; overflow: hidden; }
        .stat-card::after {
            content: '';
            position: absolute; bottom: 0; left: 0;
            width: 0; height: 3px;
            background: var(--brand);
            transition: width .3s ease;
        }
        .stat-card:hover::after { width: 100%; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #1e2d40; border-radius: 4px; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-100 antialiased" x-data="{ sidebar: false }">

{{-- Mobile overlay --}}
<div x-show="sidebar" x-cloak @click="sidebar = false"
     class="fixed inset-0 z-20 bg-black/60 lg:hidden"
     x-transition:enter="transition-opacity duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"></div>

{{-- ══════════════════════════════════════════
     SIDEBAR
══════════════════════════════════════════ --}}
<aside
    :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col
           transition-transform duration-300 ease-out lg:translate-x-0"
    style="background: var(--sidebar-bg)">

    {{-- Logo strip --}}
    <div class="flex h-16 flex-shrink-0 items-center gap-3 px-5"
         style="border-bottom: 1px solid rgba(255,255,255,.06)">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg flex-shrink-0"
             style="background: var(--brand)">
            <svg width="16" height="16" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
        <div class="leading-none">
            <p class="text-sm font-extrabold text-white" style="font-family:'Syne',sans-serif;">AsproHubs</p>
            <p class="text-[10px] font-medium mt-0.5" style="color: #6875f5;">Admin Panel</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-0.5">

        <p class="nav-group-label">Overview</p>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10-3a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"/>
            </svg>
            Dashboard
        </a>

        <p class="nav-group-label">Content</p>

        <a href="{{ route('admin.courses.index') }}"
           class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Courses
            @php $drafts = \App\Models\Course::where('status','draft')->count() @endphp
            @if($drafts > 0)
            <span class="badge-pill" style="background:#f59e0b;color:#fff">{{ $drafts }}</span>
            @endif
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Categories
        </a>

        <p class="nav-group-label">Enrollments & Users</p>

        <a href="{{ route('admin.enrollments.index') }}"
           class="nav-link {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
            </svg>
            Enrollments
            @php $pending = \App\Models\Enrollment::where('status','pending')->count() @endphp
            @if($pending > 0)
            <span class="badge-pill" style="background:#ef4444;color:#fff">{{ $pending }}</span>
            @endif
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Students
        </a>

        <p class="nav-group-label">System</p>

        <a href="{{ route('admin.settings.index') }}"
           class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Settings
        </a>

        <a href="{{ route('home') }}" target="_blank" class="nav-link">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            View Site
        </a>
    </nav>

    {{-- Admin profile strip --}}
    <div class="flex-shrink-0 px-3 py-3" style="border-top: 1px solid rgba(255,255,255,.06)">
        <div class="mb-2 flex items-center gap-3 rounded-xl px-3 py-2"
             style="background: rgba(255,255,255,.05)">
            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full
                        text-xs font-bold text-white" style="background: var(--brand)">
                {{ strtoupper(substr(auth('admin')->user()?->name ?? 'A', 0, 2)) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-xs font-semibold text-white">
                    {{ auth('admin')->user()?->name ?? 'Admin' }}
                </p>
                <p class="truncate text-[10px]" style="color: var(--sidebar-text)">
                    {{ auth('admin')->user()?->email ?? '' }}
                </p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                    class="nav-link w-full text-left hover:!bg-red-500/10 hover:!text-red-400"
                    style="color: #475569">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>

{{-- ══════════════════════════════════════════
     MAIN
══════════════════════════════════════════ --}}
<div class="flex min-h-screen flex-col lg:pl-64">

    {{-- Top bar --}}
    <header class="sticky top-0 z-10 flex h-16 flex-shrink-0 items-center justify-between
                   border-b border-slate-200 bg-white px-5 shadow-sm">

        {{-- Left: hamburger + title --}}
        <div class="flex items-center gap-3">
            <button @click="sidebar = true"
                    class="lg:hidden flex h-9 w-9 items-center justify-center rounded-lg
                           text-slate-400 hover:bg-slate-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="leading-none">
                <h1 class="font-extrabold text-slate-900 text-[15px]"
                    style="font-family:'Syne',sans-serif;">
                    @yield('page-title', 'Dashboard')
                </h1>
                @hasSection('page-subtitle')
                <p class="text-xs text-slate-400 mt-0.5">@yield('page-subtitle')</p>
                @endif
            </div>
        </div>

        {{-- Right: slot + avatar dropdown --}}
        <div class="flex items-center gap-3">
            @yield('header-actions')

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="flex h-9 w-9 items-center justify-center rounded-full
                               text-sm font-bold text-white transition hover:opacity-90"
                        style="background: var(--brand)">
                    {{ strtoupper(substr(auth('admin')->user()?->name ?? 'A', 0, 2)) }}
                </button>

                <div x-show="open" x-cloak @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     class="absolute right-0 top-12 z-50 w-52 rounded-2xl border border-slate-100
                            bg-white py-1 shadow-xl">
                    <div class="border-b border-slate-100 px-4 py-3">
                        <p class="truncate text-sm font-bold text-slate-900">
                            {{ auth('admin')->user()?->name }}
                        </p>
                        <p class="text-xs text-slate-400">Administrator</p>
                    </div>
                    <a href="{{ route('admin.settings.index') }}"
                       class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700
                              hover:bg-indigo-50 hover:text-indigo-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        </svg>
                        Settings
                    </a>
                    <div class="border-t border-slate-100 mt-1">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex w-full items-center gap-2 px-4 py-2.5
                                           text-sm text-red-600 hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Flash toasts --}}
    @foreach(['success' => ['emerald','#d1fae5','#065f46'], 'error' => ['red','#fee2e2','#991b1b'], 'warning' => ['amber','#fef3c7','#92400e'], 'info' => ['blue','#dbeafe','#1e40af']] as $type => $colors)
    @if(session($type))
    <div x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 5000)"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-5 right-5 z-50 flex max-w-sm w-full items-start gap-3
                rounded-2xl border px-5 py-4 shadow-xl text-sm font-medium"
         style="background:{{ $colors[1] }};border-color:{{ $colors[1] }};color:{{ $colors[2] }}">
        <p class="flex-1">{{ session($type) }}</p>
        <button @click="show = false" class="text-lg leading-none opacity-60 hover:opacity-100">✕</button>
    </div>
    @endif
    @endforeach

    {{-- Page content --}}
    <main class="flex-1 p-5 sm:p-7">
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
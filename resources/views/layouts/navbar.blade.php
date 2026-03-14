<nav
    x-data="{ open: false, userMenu: false }"
    class="sticky top-0 z-40 bg-white/95 backdrop-blur-sm border-b border-[var(--aspro-border)] shadow-sm"
>
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex h-16 items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-[var(--aspro-primary)]">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-lg font-bold text-gray-900" style="font-family:'Syne',sans-serif;">AsproHubs</span>
            </a>

            {{-- Desktop nav --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}"
                   class="text-sm font-medium transition
                          {{ request()->routeIs('home') ? 'text-[var(--aspro-primary)]' : 'text-gray-600 hover:text-gray-900' }}">
                    Home
                </a>
                <a href="{{ route('about') }}"
                   class="text-sm font-medium transition
                          {{ request()->routeIs('about') ? 'text-[var(--aspro-primary)]' : 'text-gray-600 hover:text-gray-900' }}">
                    About
                </a>
                <a href="{{ route('courses.index') }}"
                   class="text-sm font-medium transition
                          {{ request()->routeIs('courses.*') ? 'text-[var(--aspro-primary)]' : 'text-gray-600 hover:text-gray-900' }}">
                    Courses
                </a>
                 <a href="{{ route('contact') }}"
                   class="text-sm font-medium transition
                          {{ request()->routeIs('contact') ? 'text-[var(--aspro-primary)]' : 'text-gray-600 hover:text-gray-900' }}">
                    Contact
                </a>
            </div>

            {{-- Desktop: auth buttons or user menu --}}
            <div class="hidden md:flex items-center gap-3">
                @auth
                    {{-- User dropdown --}}
                    <div class="relative" x-data="{ userMenu: false }">
                        <button
                            @click="userMenu = !userMenu"
                            class="flex items-center gap-2 rounded-xl px-3 py-2 hover:bg-gray-50 transition"
                        >
                            <img src="{{ auth()->user()->avatar_url }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="h-7 w-7 rounded-full object-cover border border-[var(--aspro-border)]" />
                            <span class="text-sm font-semibold text-gray-700">
                                {{ Str::words(auth()->user()->name, 1, '') }}
                            </span>
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div
                            x-show="userMenu"
                            x-cloak
                            @click.outside="userMenu = false"
                            class="absolute right-0 mt-2 w-52 rounded-2xl border border-[var(--aspro-border)]
                                   bg-white shadow-xl overflow-hidden py-1"
                        >
                            <div class="px-4 py-3 border-b border-[var(--aspro-border)]">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('student.dashboard') }}"
                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700
                                      hover:bg-[var(--aspro-primary-light)] hover:text-[var(--aspro-primary)] transition">
                                Dashboard
                            </a>
                            <a href="{{ route('student.enrollments.index') }}"
                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700
                                      hover:bg-[var(--aspro-primary-light)] hover:text-[var(--aspro-primary)] transition">
                                My Enrollments
                            </a>
                            <a href="{{ route('student.profile.edit') }}"
                               class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700
                                      hover:bg-[var(--aspro-primary-light)] hover:text-[var(--aspro-primary)] transition">
                                Profile
                            </a>
                            <div class="border-t border-[var(--aspro-border)] mt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-left flex items-center gap-2 px-4 py-2.5
                                                   text-sm text-red-600 hover:bg-red-50 transition">
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-semibold text-gray-700 hover:text-[var(--aspro-primary)] transition px-3 py-2">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       class="rounded-xl px-5 py-2 text-sm font-bold text-white transition shadow-sm
                              bg-[var(--aspro-primary)] hover:bg-[var(--aspro-primary-dark)]">
                        Get Started
                    </a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button
                @click="open = !open"
                class="md:hidden flex h-9 w-9 items-center justify-center rounded-lg
                       text-gray-600 hover:bg-gray-100 transition"
            >
                <svg x-show="!open" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak class="md:hidden border-t border-[var(--aspro-border)] bg-white px-6 py-4 space-y-1">
        <a href="{{ route('home') }}"
           class="block rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700
                  hover:bg-[var(--aspro-primary-light)] hover:text-[var(--aspro-primary)] transition">
            Home
        </a>
        <a href="{{ route('courses.index') }}"
           class="block rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700
                  hover:bg-[var(--aspro-primary-light)] hover:text-[var(--aspro-primary)] transition">
            Courses
        </a>
        @auth
            <a href="{{ route('student.dashboard') }}"
               class="block rounded-xl px-4 py-2.5 text-sm font-medium text-gray-700
                      hover:bg-[var(--aspro-primary-light)] hover:text-[var(--aspro-primary)] transition">
                Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-[var(--aspro-border)]">
                @csrf
                <button type="submit"
                        class="w-full text-left block rounded-xl px-4 py-2.5 text-sm font-medium text-red-600
                               hover:bg-red-50 transition">
                    Sign Out
                </button>
            </form>
        @else
            <div class="pt-3 border-t border-[var(--aspro-border)] flex flex-col gap-2">
                <a href="{{ route('login') }}"
                   class="block rounded-xl border border-[var(--aspro-border)] px-4 py-2.5
                          text-center text-sm font-semibold text-gray-700 hover:border-[var(--aspro-primary)] transition">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                   class="block rounded-xl px-4 py-2.5 text-center text-sm font-bold text-white transition
                          bg-[var(--aspro-primary)] hover:bg-[var(--aspro-primary-dark)]">
                    Get Started
                </a>
            </div>
        @endauth
    </div>
</nav>
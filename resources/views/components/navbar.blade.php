<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <x-application-logo class="h-9 w-auto text-[var(--aspro-primary)]" />
            </a>

            <!-- DESKTOP NAV (>= md) -->
            <div class="hidden md:flex items-center gap-8">

                <!-- Links -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}"
                       class="font-medium {{ request()->routeIs('home') ? 'text-[var(--aspro-primary)] border-b-2 border-[var(--aspro-primary)]' : 'text-gray-600 hover:text-[var(--aspro-primary)]' }}">
                        Home
                    </a>

                    <a href="/about" class="font-medium text-gray-600 hover:text-[var(--aspro-primary)]">
                        About
                    </a>

                    <a href="/courses" class="font-medium text-gray-600 hover:text-[var(--aspro-primary)]">
                        Courses
                    </a>

                    <a href="/contact" class="font-medium text-gray-600 hover:text-[var(--aspro-primary)]">
                        Contact
                    </a>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-4">

                    @guest
                        <a href="{{ route('login') }}"
                           class="font-medium text-gray-600 hover:text-[var(--aspro-primary)]">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                           class="btn-aspro">
                            Get Started
                        </a>
                    @endguest

                    @auth
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown"
                                class="flex items-center gap-2 rounded-full border px-3 py-1 hover:bg-gray-50">
                                <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="dropdown" @click.outside="dropdown = false"
                                 class="absolute right-0 mt-2 w-48 rounded-xl bg-white shadow-lg border">
                                <a href="{{ route('dashboard') }}"
                                   class="block px-4 py-2 text-sm hover:bg-gray-100">
                                    Dashboard
                                </a>

                                <a href="{{ route('profile.edit') }}"
                                   class="block px-4 py-2 text-sm hover:bg-gray-100">
                                    Profile
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                </div>
            </div>

            <!-- MOBILE TOGGLE (< md only) -->
            <button @click="open = !open"
                class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-600 hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'block': !open}"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !open, 'block': open}"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="md:hidden border-t bg-white">
        <div class="space-y-3 px-4 py-4">

            <a href="{{ route('home') }}" class="block font-medium">Home</a>
            <a href="/about" class="block font-medium">About</a>
            <a href="/courses" class="block font-medium">Courses</a>
            <a href="/contact" class="block font-medium">Contact</a>

            @guest
                <a href="{{ route('login') }}" class="block text-[var(--aspro-primary)] font-medium">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="block text-center btn-aspro">
                    Get Started
                </a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}" class="block font-medium">
                    Dashboard
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="block text-left text-red-600 font-medium">
                        Logout
                    </button>
                </form>
            @endauth

        </div>
    </div>
</nav>

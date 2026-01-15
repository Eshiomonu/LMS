<<<<<<< HEAD
<nav x-data="{ open: false }" class="bg-white shadow-sm">
    <!-- Primary Navigation Menu -->
=======
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50">
>>>>>>> 4408a419119e0dd162f12c862ae91b1d36b2b5ac
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left: Logo + Nav -->
            <div class="flex items-center gap-10">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <x-application-logo class="block h-9 w-auto text-gray-800" />
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center gap-6">
                    <x-nav-link href="/" :active="request()->is('/')">Home</x-nav-link>
                    <x-nav-link href="/about" :active="request()->is('about')">About</x-nav-link>
                    <x-nav-link href="/courses" :active="request()->is('courses*')">Courses</x-nav-link>
                    <x-nav-link href="/contact" :active="request()->is('contact')">Contact</x-nav-link>
                </div>
            </div>

            <!-- Right: Auth / Guest -->
            <div class="hidden md:flex items-center gap-4">

                @guest
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-gray-600 hover:text-indigo-600">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                        Get Started
                    </a>
                @endguest

                @auth
                    <div class="relative" x-data="{ dropdown: false }">
                        <button @click="dropdown = !dropdown"
                            class="flex items-center gap-2 rounded-full border px-2 py-1 hover:bg-gray-50">
                            <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
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
                                <button
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center md:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}"
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}"
                              class="hidden" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="md:hidden border-t bg-white">
        <div class="space-y-2 px-4 py-4">
            <a href="/" class="block">Home</a>
            <a href="/about" class="block">About</a>
            <a href="/courses" class="block">Courses</a>
            <a href="/contact" class="block">Contact</a>

            @guest
                <a href="{{ route('login') }}" class="block text-indigo-600">Login</a>
                <a href="{{ route('register') }}"
                   class="block rounded-lg bg-indigo-600 px-4 py-2 text-center text-white">
                    Get Started
                </a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}" class="block">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="block w-full text-left text-red-600">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<nav class="sticky top-0 z-50 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex h-16 items-center justify-between">

            <!-- LOGO -->
            <a href="{{ route('home') }}"
               class="flex items-center gap-2"
               aria-label="{{ config('app.name') }} home">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="{{ config('app.name') }} logo"
                    class="h-9 w-auto"
                    loading="eager"
                />
            </a>

            <!-- DESKTOP NAV -->
            <div class="hidden md:flex items-center gap-10">

                <!-- NAV LINKS -->
                <ul class="flex items-center gap-6" role="navigation" aria-label="Main navigation">

                    @php
                        $linkClass = fn ($active) =>
                            'relative font-medium text-sm transition-colors
                             after:absolute after:left-0 after:-bottom-1 after:h-0.5
                             after:w-0 after:bg-[var(--aspro-primary)]
                             after:transition-all after:duration-300
                             hover:text-[var(--aspro-primary)]
                             hover:after:w-full ' .
                             ($active
                                ? 'text-[var(--aspro-primary)] after:w-full'
                                : 'text-gray-700');
                    @endphp

                    <li>
                        <a href="{{ route('home') }}"
                           class="{{ $linkClass(request()->routeIs('home')) }}">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('about') }}"
                           class="{{ $linkClass(request()->routeIs('about')) }}">
                            About
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('courses.index') }}"
                           class="{{ $linkClass(request()->routeIs('courses.*')) }}">
                            Courses
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('contact') }}"
                           class="{{ $linkClass(request()->routeIs('contact')) }}">
                            Contact
                        </a>
                    </li>
                </ul>

                <!-- CTA -->
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center
                          rounded-lg bg-[var(--aspro-primary)]
                          px-5 py-2.5 text-sm font-semibold text-white
                          shadow-sm transition
                          hover:bg-[var(--aspro-primary-dark)]
                          focus:outline-none focus:ring-2 focus:ring-offset-2
                          focus:ring-[var(--aspro-primary)]">
                    Get Started
                </a>
            </div>

            <!-- MOBILE MENU BUTTON -->
            <button
                x-data="{ open: false }"
                @click="open = !open"
                aria-label="Toggle menu"
                aria-expanded="false"
                class="md:hidden inline-flex items-center justify-center
                       rounded-md p-2 text-gray-700
                       hover:bg-gray-100">

                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12" />
                </svg>

                <!-- MOBILE MENU -->
                <div x-show="open"
                     x-transition
                     class="absolute top-16 left-0 w-full bg-white border-t border-gray-200">

                    <div class="px-4 py-5 space-y-3">

                        <a href="{{ route('home') }}"
                           class="block font-medium
                           {{ request()->routeIs('home')
                               ? 'text-[var(--aspro-primary)] border-l-4 border-[var(--aspro-primary)] pl-3'
                               : 'text-gray-700' }}">
                            Home
                        </a>

                        <a href="{{ route('about') }}"
                           class="block font-medium
                           {{ request()->routeIs('about')
                               ? 'text-[var(--aspro-primary)] border-l-4 border-[var(--aspro-primary)] pl-3'
                               : 'text-gray-700' }}">
                            About
                        </a>

                        <a href="{{ route('courses.index') }}"
                           class="block font-medium
                           {{ request()->routeIs('courses.*')
                               ? 'text-[var(--aspro-primary)] border-l-4 border-[var(--aspro-primary)] pl-3'
                               : 'text-gray-700' }}">
                            Courses
                        </a>

                        <a href="{{ route('contact') }}"
                           class="block font-medium
                           {{ request()->routeIs('contact')
                               ? 'text-[var(--aspro-primary)] border-l-4 border-[var(--aspro-primary)] pl-3'
                               : 'text-gray-700' }}">
                            Contact
                        </a>

                        <a href="{{ route('register') }}"
                           class="block text-center mt-4 rounded-lg
                                  bg-[var(--aspro-primary)]
                                  px-5 py-3 text-sm font-semibold text-white
                                  hover:bg-[var(--aspro-primary-dark)]">
                            Get Started
                        </a>
                    </div>
                </div>
            </button>

        </div>
    </div>
</nav>

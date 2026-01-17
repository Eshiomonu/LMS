<nav x-data="{ open: false, darkMode: false, dropdown: false }" 
     :class="darkMode ? 'dark bg-slate-900 text-white' : 'bg-white text-gray-700'" 
     class="shadow-sm sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex justify-between items-center h-16">

      <!-- Logo -->
      <a href="{{ route('home') }}" class="flex items-center">
        <span class="sr-only">AsproHub home</span>
        <img src="{{ asset('build/assets/logo.png') }}" alt="AsproHub logo" class="h-8 w-auto object-contain" />
      </a>

      <!-- Desktop Links -->
      <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
        <a href="{{ route('home') }}" class="hover:text-brand-600" 
           :class="darkMode ? 'text-white' : 'text-brand-600'">Home</a>
        <a href="/about" class="hover:text-brand-600" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">About</a>
        <a href="/courses" class="hover:text-brand-600" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Courses</a>
        <a href="/blog" class="hover:text-brand-600" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Blog</a>
        <a href="/contact" class="hover:text-brand-600" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Contact</a>
      </div>

      <!-- Right Section -->
      <div class="flex items-center space-x-4">

        <!-- Dark Mode Toggle -->
        <button @click="darkMode = !darkMode"
                class="p-2 rounded-md transition-colors duration-200"
                :class="darkMode ? 'bg-slate-800 hover:bg-slate-700 text-white' : 'bg-white hover:bg-gray-50 text-gray-700'">
          <span class="sr-only">Toggle dark mode</span>
          <!-- Light Icon -->
          <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.36 6.36l-1.41-1.41M6.05 6.05L4.64 4.64M16.95 7.05L18.36 5.64M7.05 17.95L5.64 19.36"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8a4 4 0 100 8 4 4 0 000-8z"/>
          </svg>
          <!-- Dark Icon -->
          <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
          </svg>
        </button>

        <!-- Auth Buttons -->
        @guest
          <a href="{{ route('login') }}" 
             class="bg-brand-600 text-white px-4 py-2 rounded-md text-sm hover:bg-brand-700">
            Sign In
          </a>
        @endguest

        @auth
          <div class="relative" x-data="{ dropdown: false }">
            <button @click="dropdown = !dropdown" class="flex items-center gap-2 rounded-full border px-3 py-1 hover:bg-gray-50">
              <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
              <svg class="h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
              </svg>
            </button>

            <div x-show="dropdown" @click.outside="dropdown = false" 
                 class="absolute right-0 mt-2 w-48 rounded-xl bg-white shadow-lg border z-50">
              <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Dashboard</a>
              <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Profile</a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
              </form>
            </div>
          </div>
        @endauth

        <!-- Mobile Toggle -->
        <button @click="open = !open" class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-600 hover:bg-gray-100">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'block': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            <path :class="{'hidden': !open, 'block': open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>

      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div x-show="open" class="md:hidden border-t bg-white">
    <div class="space-y-3 px-4 py-4">
      <a href="{{ route('home') }}" class="block font-medium">Home</a>
      <a href="/about" class="block font-medium">About</a>
      <a href="/courses" class="block font-medium">Courses</a>
      <a href="/blog" class="block font-medium">Blog</a>
      <a href="/contact" class="block font-medium">Contact</a>

      @guest
        <a href="{{ route('login') }}" class="block text-[var(--aspro-primary)] font-medium">Login</a>
        <a href="{{ route('register') }}" class="block text-center btn-aspro">Get Started</a>
      @endguest

      @auth
        <a href="{{ route('dashboard') }}" class="block font-medium">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="block text-left text-red-600 font-medium">Logout</button>
        </form>
      @endauth
    </div>
  </div>
</nav>

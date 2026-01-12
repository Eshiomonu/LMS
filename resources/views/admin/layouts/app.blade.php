<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Tailwind CSS CDN (optional, replace with your own CSS if you prefer) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 min-h-screen text-white flex-shrink-0">
        <div class="p-4 font-bold text-xl border-b border-gray-700">
            LMS Admin
        </div>
        <nav class="p-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-700 {{ request()->is('admin/dashboard') ? 'bg-gray-700' : '' }}">
                        Dashboard
                    </a>
                </li>
              <li>
    <span class="block py-2 px-4 text-gray-400 uppercase text-xs">
        Course Management
    </span>
</li>

<li>
    <a href="{{ route('admin.courses.index') }}"
       class="block py-2 px-4 rounded
       {{ request()->routeIs('admin.courses.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
        Courses
    </a>
</li>
                <!-- Add more sidebar links here -->
            </ul>
        </nav>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <div class="font-bold text-lg">@yield('header-title', 'Dashboard')</div>
            <div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white text-center p-4 border-t border-gray-300">
            &copy; {{ date('Y') }} LMS Admin Panel
        </footer>

        @if (session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
        {{ session('error') }}
    </div>
@endif

    </div>

</body>
</html>

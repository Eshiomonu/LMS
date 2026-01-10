<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">

    <div class="flex flex-col md:flex-row bg-white shadow-2xl rounded-2xl overflow-hidden w-full max-w-5xl">

        <!-- Left column: Image -->
        <div class="hidden md:block md:w-1/2 bg-gradient-to-tr from-blue-600 to-indigo-600 relative">
            <img src="https://source.unsplash.com/800x800/?technology,education" alt="Admin Login Image" class="absolute inset-0 w-full h-full object-cover opacity-90">
            <div class="absolute inset-0 bg-black bg-opacity-25 flex items-center justify-center">
                <h1 class="text-white text-3xl font-bold px-4 text-center">
                    Welcome Back, Admin
                </h1>
            </div>
        </div>

        <!-- Right column: Form -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">

            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Admin Login</h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="admin@example.com"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required
                        autofocus
                    >
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2" for="password">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="********"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required
                    >
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition duration-300"
                    >
                        Login
                    </button>
                </div>
            </form>

            <p class="mt-6 text-center text-gray-500">
                &copy; {{ date('Y') }} Asprohub Admin Panel
            </p>
        </div>

    </div>

</body>
</html>

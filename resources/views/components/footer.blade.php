<footer class="bg-white border-t border-gray-200 mt-20">
    <div class="max-w-7xl mx-auto px-6 py-16">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">

            {{-- Brand --}}
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="AsproHubs Logo" class="h-10 mb-4">

                <p class="text-gray-600 text-sm leading-relaxed">
                    AsproHubs is a professional learning platform for individuals and organizations.
                    Learn, grow, and build high-value skills with industry-grade courses.
                </p>

                <div class="flex items-center gap-4 mt-6">
                    <a href="#" class="text-gray-500 hover:text-blue-600">
                        <svg class="w-5 h-5" fill="currentColor"><!-- Facebook --></svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-500">
                        <svg class="w-5 h-5" fill="currentColor"><!-- Twitter --></svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-700">
                        <svg class="w-5 h-5" fill="currentColor"><!-- LinkedIn --></svg>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-red-600">
                        <svg class="w-5 h-5" fill="currentColor"><!-- YouTube --></svg>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-blue-600">About Us</a></li>
                    <li><a href="{{ route('courses.index') }}" class="hover:text-blue-600">Courses</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-blue-600">Contact</a></li>
                </ul>
            </div>

            {{-- Support --}}
            <div>
                <h4 class="font-semibold mb-4">Support</h4>
                <ul class="space-y-3 text-sm text-gray-600">
                    <li><a href="#" class="hover:text-blue-600">FAQ</a></li>
                    <li><a href="#" class="hover:text-blue-600">Terms & Conditions</a></li>
                    <li><a href="#" class="hover:text-blue-600">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-blue-600">Help Center</a></li>
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="font-semibold mb-4">Join Our Newsletter</h4>
                <p class="text-sm text-gray-600 mb-4">
                    Stay updated with new courses & learning opportunities.
                </p>

                <form class="flex">
                    <input type="email"
                           placeholder="Enter your email"
                           class="w-full px-4 py-3 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <button class="bg-indigo-600 text-white px-6 py-3 rounded-r-md hover:bg-indigo-700">
                        Subscribe
                    </button>
                </form>
            </div>

        </div>

        {{-- Divider --}}
        <div class="border-t border-gray-200 mt-12 pt-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} AsproHubs. All Rights Reserved.
        </div>

    </div>
</footer>

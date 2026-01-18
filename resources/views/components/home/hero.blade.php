<section class="relative min-h-[85vh] flex items-center overflow-hidden">

    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img
            src="{{ asset('images/home/hero.jpg') }}"
            alt="Professional learning and skill development"
            class="h-full w-full object-cover"
        />
    </div>

    <!-- Dark Overlay -->
    <div class="absolute inset-0 z-10 bg-black/70"></div>

    <!-- Content -->
    <div class="relative z-20 max-w-7xl mx-auto px-6 text-center text-white">

        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight">
            Learn Industry-Ready Skills
            <span class="block text-(--aspro-primary-light)">
                Build a Future-Proof Career
            </span>
        </h1>

        <p class="mt-6 max-w-2xl mx-auto text-lg sm:text-xl text-gray-200">
            AsproHubs delivers hands-on, expert-led courses designed to help
            professionals grow, transition, and excel in today’s competitive world.
        </p>

        <!-- CTA Buttons -->
        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">

            <!-- View Courses -->
            <a
                href="{{ route('courses.index') }}"
                class="inline-flex items-center justify-center px-8 py-3 rounded-xl
                       border-2 border-white text-white font-semibold
                       hover:bg-white hover:text-(--aspro-primary)
                       transition-all duration-200"
            >
                View Courses
            </a>

            <!-- Get Started -->
            <a
                href="{{ route('register') }}"
                class="inline-flex items-center justify-center px-8 py-3 rounded-xl
                       bg-(--aspro-primary) text-white font-semibold
                       hover:bg-(--aspro-primary-dark)
                       shadow-lg transition-all duration-200"
            >
                Get Started
            </a>

        </div>
    </div>
</section>

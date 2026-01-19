<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900">
                Our Popular Courses
            </h2>
            <p class="mt-4 text-gray-600 text-lg">
                Learn in-demand skills taught by experienced professionals.
            </p>
        </div>

        <!-- Courses Grid -->
        <div class="mt-14 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

            @foreach($courses as $course)
                <div
                    class="group bg-white rounded-2xl overflow-hidden border border-gray-200
                           hover:shadow-xl transition-all duration-300"
                >
                    <!-- Image -->
                    <a href="{{ route('courses.show', $course) }}" class="block overflow-hidden">
                        <img
                            src="{{ asset('storage/'.$course->card_image) }}"
                            alt="{{ $course->title }}"
                            class="h-52 w-full object-cover group-hover:scale-105 transition duration-300"
                        />
                    </a>

                    <!-- Content -->
                    <div class="p-6 flex flex-col h-full">

                        <h3 class="text-lg font-bold text-gray-900">
                            <a href="{{ route('courses.show', $course) }}"
                               class="hover:text-[var(--aspro-primary)]">
                                {{ $course->title }}
                            </a>
                        </h3>

                        <p class="mt-3 text-sm text-gray-600 line-clamp-3">
                            {{ $course->short_description }}
                        </p>

                        <div class="mt-5 flex items-center justify-between text-sm text-gray-500">
                            <span>{{ $course->duration_weeks }} weeks</span>
                            <span>{{ ucfirst(str_replace('_', ' ', $course->mode)) }}</span>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center gap-1 text-sm">
                                <span class="font-semibold text-gray-900">
                                    {{ number_format($course->rating, 1) }}
                                </span>
                                <span class="text-yellow-500">★</span>
                                <span class="text-gray-500">
                                    ({{ number_format($course->enrollments) }})
                                </span>
                            </div>

                            <span class="text-lg font-bold text-[var(--aspro-primary)]">
                                ₦{{ number_format($course->course_fee) }}
                            </span>
                        </div>

                        <a
                            href="{{ route('courses.show', $course) }}"
                            class="mt-6 inline-flex items-center justify-center rounded-xl
                                   border border-[var(--aspro-primary)]
                                   px-4 py-2 text-sm font-semibold
                                   text-[var(--aspro-primary)]
                                   hover:bg-[var(--aspro-primary)]
                                   hover:text-white transition"
                        >
                            View Course
                        </a>
                    </div>
                </div>
            @endforeach

        </div>

        <!-- View More -->
        <div class="mt-16 text-center">
            <a
                href="{{ route('courses.index') }}"
                class="inline-flex items-center justify-center
                       rounded-xl bg-[var(--aspro-primary)]
                       px-8 py-3 font-semibold text-white
                       hover:bg-[var(--aspro-primary-dark)]
                       transition shadow-lg"
            >
                View More Courses
            </a>
        </div>

    </div>
</section>

<section class="py-24 bg-[var(--aspro-light)]">
    <div class="max-w-7xl mx-auto px-6">

        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-14">
            <h2 class="text-3xl md:text-4xl font-extrabold text-[var(--aspro-dark)]">
                Choose Your Learning Path
            </h2>
            <p class="mt-4 text-gray-600">
                Select the training format that fits your schedule and learning preferences.
            </p>
        </div>

        {{-- Cards --}}
        <div class="grid gap-8 md:grid-cols-3">

            {{-- Card 1: On-site Training --}}
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-[var(--aspro-border)]
                        hover:shadow-lg transition">

                <div class="h-12 w-12 flex items-center justify-center rounded-xl
                            bg-[var(--aspro-primary-light)] mb-6">
                    <svg class="h-6 w-6 text-[var(--aspro-primary)]" fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6" />
                    </svg>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                    On-site Training
                </h3>

                <p class="text-gray-600 mb-6">
                    Learn directly from certified experts through structured in-person training sessions.
                </p>

                <ul class="space-y-3 text-sm text-gray-700 mb-8">
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Hands-on practical sessions
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Group activities & workshops
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Trained at your organization
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Instant certification
                    </li>
                </ul>

                <a href="#"
                   class="inline-flex items-center justify-center w-full px-6 py-3 rounded-xl
                          bg-[var(--aspro-primary)] text-white font-semibold
                          hover:bg-[var(--aspro-primary-dark)] transition">
                    Request On-site Training
                </a>
            </div>

            {{-- Card 2: Live / Virtual Training --}}
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-[var(--aspro-border)]
                        hover:shadow-lg transition">

                <div class="h-12 w-12 flex items-center justify-center rounded-xl
                            bg-[var(--aspro-primary-light)] mb-6">
                    <svg class="h-6 w-6 text-[var(--aspro-primary)]" fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m-6 0H5a2 2 0 01-2-2V8a2 2 0 012-2h4l5-3v18l-5-3z"/>
                    </svg>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                    Live Virtual Training
                </h3>

                <p class="text-gray-600 mb-6">
                    Instructor-led live sessions delivered remotely with real-time interaction.
                </p>

                <ul class="space-y-3 text-sm text-gray-700 mb-8">
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Live instructor sessions
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Interactive Q&A
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Recorded sessions
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Certificate of completion
                    </li>
                </ul>

                <a href="{{ route('courses.index') }}"
                   class="inline-flex items-center justify-center w-full px-6 py-3 rounded-xl
                          border-2 border-[var(--aspro-primary)]
                          text-[var(--aspro-primary)] font-semibold
                          hover:bg-[var(--aspro-primary-light)] transition">
                    View Live Courses
                </a>
            </div>

            {{-- Card 3: Self-paced LMS --}}
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-[var(--aspro-border)]
                        hover:shadow-lg transition">

                <div class="h-12 w-12 flex items-center justify-center rounded-xl
                            bg-[var(--aspro-primary-light)] mb-6">
                    <svg class="h-6 w-6 text-[var(--aspro-primary)]" fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 4h16v12H4zM2 20h20"/>
                    </svg>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-2">
                    Self-paced LMS
                </h3>

                <p class="text-gray-600 mb-6">
                    Learn anytime, anywhere with flexible access to our interactive learning platform.
                </p>

                <ul class="space-y-3 text-sm text-gray-700 mb-8">
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> 24/7 access to modules
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Videos & quizzes
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Mobile-friendly dashboard
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[var(--aspro-primary)]">✓</span> Learn at your own pace
                    </li>
                </ul>

                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center w-full px-6 py-3 rounded-xl
                          border-2 border-[var(--aspro-primary)]
                          text-[var(--aspro-primary)] font-semibold
                          hover:bg-[var(--aspro-primary-light)] transition">
                    Start Learning
                </a>
            </div>

        </div>
    </div>
</section>

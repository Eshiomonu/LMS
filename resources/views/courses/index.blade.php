@extends('layouts.app')

@section('title', 'All Courses')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">

    {{-- Heading --}}
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-extrabold text-gray-900">
            Explore Our Courses
        </h1>
        <p class="mt-2 text-gray-600 max-w-2xl mx-auto">
            Learn industry-recognized skills with expert-led, practical training.
        </p>
    </div>

    @if($courses->count() > 0)

        {{-- Course Grid --}}
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

            @foreach($courses as $course)
                <a
                    href="{{ route('courses.show',$course) }}"
                    class="group bg-white rounded-2xl border border-gray-200 overflow-hidden
                           hover:shadow-xl transition-shadow duration-300 flex flex-col"
                >

                    {{-- Image --}}
                    <div class="relative h-48 overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $course->card_image) }}"
                            alt="{{ $course->title }}"
                            class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                        />
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col flex-1">

                        {{-- Category Badge --}}
                        <div class="mb-3">
                            <span class="inline-block text-xs font-semibold px-3 py-1 rounded-full
                                         bg-(--aspro-primary-light)] text-[var(--aspro-primary)">
                                {{ $course->category->name ?? 'Business' }}
                            </span>
                        </div>

                        {{-- Title --}}
                        <h3 class="text-lg font-bold text-gray-900 leading-snug">
                            {{ $course->title }}
                        </h3>

                        {{-- Rating --}}
                        <div class="mt-2 flex items-center gap-2 text-sm">
                            <div class="flex text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($course->average_rating) ? 'fill-current' : 'text-gray-300' }}"
                                         viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.175c.969 0 1.371 1.24.588 1.81l-3.378 2.455a1 1 0 00-.364 1.118l1.286 3.966c.3.922-.755 1.688-1.538 1.118l-3.379-2.454a1 1 0 00-1.175 0l-3.379 2.454c-.783.57-1.838-.196-1.538-1.118l1.286-3.966a1 1 0 00-.364-1.118L2.05 9.394c-.783-.57-.38-1.81.588-1.81h4.175a1 1 0 00.95-.69l1.286-3.967z"/>
                                    </svg>
                                @endfor
                            </div>

                            <span class="text-gray-500">
                                ({{ $course->reviews_count ?? 0 }})
                            </span>
                        </div>

                        {{-- Description --}}
                        <p class="mt-3 text-sm text-gray-600 line-clamp-2">
                            {{ $course->short_description }}
                        </p>

                        {{-- Meta --}}
                        <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center gap-1">
                                ⏱ {{ $course->duration_weeks }} weeks
                            </div>
                            <div class="flex items-center gap-1">
                                👥 {{ $course->enrollment_count }} enrolled
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="mt-6 flex items-center justify-between">
                            <span class="text-xl font-extrabold text-(--aspro-primary)">
                                ₦{{ number_format($course->course_fee, 2) }}
                            </span>

                            <span
                                class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold
                                       bg-(--aspro-primary) text-white
                                       group-hover:bg-(--aspro-primary-dark)
                                       transition-colors"
                            >
                                View Details
                            </span>
                        </div>

                    </div>
                </a>
            @endforeach

        </div>

        {{-- Pagination --}}
        <div class="mt-12">
            {{ $courses->links() }}
        </div>

    @else
        <p class="text-center text-gray-500">
            No courses available at the moment.
        </p>
    @endif

</div>
@endsection

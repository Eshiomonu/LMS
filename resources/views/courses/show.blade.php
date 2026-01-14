@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="grid md:grid-cols-3 gap-8">

        {{-- Left Column: Images --}}
        <div class="md:col-span-1">
            <img src="{{ asset('storage/'.$course->hero_image) }}" alt="{{ $course->title }}"
                 class="rounded shadow mb-6 w-full object-cover h-64">

            <div class="bg-white rounded shadow p-4">
                <p class="font-semibold mb-2">Course Fee</p>
                <p class="text-lg font-bold mb-2">₦{{ number_format($course->course_fee) }}</p>

                <p class="font-semibold mb-2">Duration</p>
                <p>{{ $course->duration_hours }} hours ({{ $course->duration_weeks }} weeks)</p>

                <p class="font-semibold mb-2 mt-4">Mode</p>
                <p>{{ ucfirst(str_replace('_', ' ', $course->mode)) }}</p>

                <p class="font-semibold mb-2 mt-4">Schedule</p>
                <p>{{ $course->schedule }} - {{ $course->time }}</p>

                <p class="font-semibold mb-2 mt-4">Recordings</p>
                <p>{{ $course->recording ? 'Available' : 'Not Available' }}</p>

                {{-- Enroll Button --}}
                @auth
                    <a href="{{ route('courses.enroll', $course->id) }}"
                       class="mt-6 block bg-green-600 text-white text-center px-4 py-3 rounded hover:bg-green-700">
                        Enroll Now
                    </a>
                @else
                    <a href="{{ route('login') }}?redirect={{ route('courses.enroll', $course->id) }}"
                       class="mt-6 block bg-blue-600 text-white text-center px-4 py-3 rounded hover:bg-blue-700">
                        Login to Enroll
                    </a>
                @endauth
            </div>
        </div>

        {{-- Right Column: Details --}}
        <div class="md:col-span-2 space-y-6">
            <h1 class="text-3xl font-bold">{{ $course->title }}</h1>

            <p class="text-gray-700">{{ $course->long_description }}</p>

            <div>
                <h2 class="font-semibold text-xl mb-2">Who This Course is For</h2>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach($course->who_this_course_is_for as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="font-semibold text-xl mb-2">Course Curriculum</h2>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach($course->curriculum as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="font-semibold text-xl mb-2">What You Will Get</h2>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach($course->what_you_get as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="font-semibold text-xl mb-2">Why Train With Us?</h2>
                <ul class="list-disc list-inside text-gray-700">
                    @foreach($course->why_train_with_us as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

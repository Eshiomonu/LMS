@extends('layouts.app') {{-- Use your main frontend layout --}}

@section('title', 'All Courses')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-8">All Courses</h1>

    @if($courses->count() > 0)
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($courses as $course)
                <div class="bg-white rounded shadow overflow-hidden flex flex-col">
                    {{-- Course Card Image --}}
                    <img src="{{ asset('storage/'.$course->card_image) }}" alt="{{ $course->title }}"
                         class="h-48 w-full object-cover">

                    <div class="p-4 flex-1 flex flex-col">
                        <h2 class="text-xl font-semibold mb-2">{{ $course->title }}</h2>
                        <p class="text-gray-600 mb-4">{{ $course->short_description }}</p>

                        <div class="mt-auto">
                            <a href="{{ route('courses.show', $course->id) }}"
                               class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                               View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $courses->links() }} {{-- TailwindCSS pagination --}}
        </div>
    @else
        <p class="text-gray-500">No courses found.</p>
    @endif
</div>
@endsection

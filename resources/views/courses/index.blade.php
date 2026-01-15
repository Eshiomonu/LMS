@extends('layouts.app')

@section('title', 'All Courses – AsproHubs')

@section('meta_description', 'Browse all professional courses available on AsproHubs.')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">All Courses</h1>

    @if($courses->isEmpty())
        <p class="text-gray-600 dark:text-gray-400">No courses available at the moment.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 dark:bg-slate-700 flex items-center justify-center">
                            <span class="text-gray-400">No Image</span>
                        </div>
                    @endif
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $course->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ Str::limit($course->description, 100) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-blue-600 dark:text-blue-400">₦{{ number_format($course->price, 2) }}</span>
                            <a href="{{ route('courses.show', $course->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    @endif
</div>
@endsection

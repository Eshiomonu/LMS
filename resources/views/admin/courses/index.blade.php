@extends('admin.layouts.app')

@section('title', 'Courses')
@section('header-title', 'Courses')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">All Courses</h2>

    <a href="{{ route('admin.courses.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Create Course
    </a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-800 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-3 text-left">Title</th>
                <th class="px-4 py-3 text-left">Mode</th>
                <th class="px-4 py-3 text-left">Duration</th>
                <th class="px-4 py-3 text-left">Fee</th>
                <th class="px-4 py-3 text-center">Featured</th>
                <th class="px-4 py-3 text-center">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($courses as $course)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">
                        {{ $course->title }}
                    </td>

                    <td class="px-4 py-3 capitalize">
                        {{ str_replace('_', ' ', $course->mode) }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $course->duration_weeks }} weeks /
                        {{ $course->duration_hours }} hrs
                    </td>

                    <td class="px-4 py-3">
                        ₦{{ number_format($course->course_fee, 2) }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        @if($course->is_featured)
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                Yes
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded">
                                No
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="{{ route('admin.courses.edit', $course) }}"
                           class="text-blue-600 hover:underline">
                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('admin.courses.destroy', $course) }}"
                              class="inline"
                              onsubmit="return confirm('Delete this course?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-600 hover:underline">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center px-4 py-6 text-gray-500">
                        No courses created yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $courses->links() }}
</div>

@endsection

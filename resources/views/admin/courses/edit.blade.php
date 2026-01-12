@extends('admin.layouts.app')

@section('title', 'Edit Course')
@section('header-title', 'Edit Course')

@section('content')

<form method="POST"
      action="{{ route('admin.courses.update', $course->id) }}"
      enctype="multipart/form-data"
      class="max-w-5xl space-y-10">
    @csrf
    @method('PUT')

    {{-- GLOBAL ERRORS --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-800 p-4 rounded">
            <p class="font-semibold mb-2">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- BASIC INFORMATION --}}
    <section class="bg-white p-6 rounded shadow space-y-6">
        <div>
            <h2 class="text-xl font-semibold">Basic Information</h2>
            <p class="text-sm text-gray-500">This information appears on the course card and detail page.</p>
        </div>

        <div>
            <label class="label">Course Title</label>
            <input name="title" class="input w-full"
                   value="{{ old('title', $course->title) }}">
            @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="label">Short Description</label>
            <textarea name="short_description" rows="2" class="input w-full">{{ old('short_description', $course->short_description) }}</textarea>
            @error('short_description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="label">Full Course Description</label>
            <textarea name="long_description" rows="6" class="input w-full">{{ old('long_description', $course->long_description) }}</textarea>
            @error('long_description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </section>

    {{-- LIST SECTIONS --}}
    @include('admin.courses.partials.list-field', [
        'label' => 'Who Is This Course For?',
        'description' => 'List the target audience.',
        'name' => 'who_this_course_is_for',
        'values' => old('who_this_course_is_for', $course->who_this_course_is_for)
    ])

    @include('admin.courses.partials.list-field', [
        'label' => 'Course Curriculum',
        'description' => 'List modules or topics.',
        'name' => 'curriculum',
        'values' => old('curriculum', $course->curriculum)
    ])

    @include('admin.courses.partials.list-field', [
        'label' => 'What Students Will Get',
        'description' => 'Certificates, mentorship, projects, etc.',
        'name' => 'what_you_get',
        'values' => old('what_you_get', $course->what_you_get)
    ])

    @include('admin.courses.partials.list-field', [
        'label' => 'Why Train With Us?',
        'description' => 'Reasons students should choose you.',
        'name' => 'why_train_with_us',
        'values' => old('why_train_with_us', $course->why_train_with_us)
    ])

    {{-- COURSE DETAILS --}}
    <section class="bg-white p-6 rounded shadow space-y-6">
        <div>
            <h2 class="text-xl font-semibold">Course Details</h2>
            <p class="text-sm text-gray-500">Schedule, delivery and pricing.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="label">Duration (Hours)</label>
                <input type="number" name="duration_hours" class="input w-full"
                       value="{{ old('duration_hours', $course->duration_hours) }}">
                @error('duration_hours') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label">Duration (Weeks)</label>
                <input type="number" name="duration_weeks" class="input w-full"
                       value="{{ old('duration_weeks', $course->duration_weeks) }}">
                @error('duration_weeks') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label">Course Mode</label>
                <select name="mode" class="input w-full">
                    <option value="">Select mode</option>
                    <option value="live_online" @selected(old('mode', $course->mode) === 'live_online')>Live Online</option>
                    <option value="virtual" @selected(old('mode', $course->mode) === 'virtual')>Virtual</option>
                    <option value="onsite" @selected(old('mode', $course->mode) === 'onsite')>Onsite</option>
                </select>
                @error('mode') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="label">Course Fee</label>
                <input type="number" step="0.01" name="course_fee" class="input w-full"
                       value="{{ old('course_fee', $course->course_fee) }}">
                @error('course_fee') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="label">Schedule</label>
            <textarea name="schedule" rows="2" class="input w-full">{{ old('schedule', $course->schedule) }}</textarea>
            @error('schedule') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="label">Time</label>
            <input name="time" class="input w-full"
                   value="{{ old('time', $course->time) }}">
            @error('time') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </section>

    {{-- OPTIONS --}}
    <section class="bg-white p-6 rounded shadow flex flex-col md:flex-row gap-6">
        <label class="flex items-center gap-3">
            <input type="checkbox" name="recording" value="1" @checked(old('recording', $course->recording))>
            <span>Class recordings available</span>
        </label>

        <label class="flex items-center gap-3">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $course->is_featured))>
            <span>Feature this course on homepage</span>
        </label>
    </section>

    {{-- IMAGES WITH CURRENT & NEW PREVIEW --}}
    <section class="bg-white p-6 rounded shadow space-y-6">
        <div>
            <h2 class="text-xl font-semibold">Course Images</h2>
            <p class="text-sm text-gray-500">Upload clear JPG or PNG images.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            {{-- Card Image --}}
            <div>
                <label class="label">Course Card Image</label>
                <input type="file" name="card_image" accept="image/*"
                       class="input w-full"
                       onchange="previewImage(event, 'cardPreview')">
                {{-- Current image --}}
                <img src="{{ asset('storage/'.$course->card_image) }}"
                     class="mt-3 h-40 object-cover rounded border"
                     id="cardPreview">
                @error('card_image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Hero Image --}}
            <div>
                <label class="label">Course Hero Image</label>
                <input type="file" name="hero_image" accept="image/*"
                       class="input w-full"
                       onchange="previewImage(event, 'heroPreview')">
                {{-- Current image --}}
                <img src="{{ asset('storage/'.$course->hero_image) }}"
                     class="mt-3 h-40 object-cover rounded border"
                     id="heroPreview">
                @error('hero_image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- SUBMIT --}}
    <div class="pt-4">
        <button class="bg-green-600 text-white px-8 py-3 rounded text-lg hover:bg-green-700">
            Update Course
        </button>
    </div>
</form>

{{-- IMAGE PREVIEW SCRIPT --}}
<script>
function previewImage(event, previewId) {
    const img = document.getElementById(previewId);
    img.src = URL.createObjectURL(event.target.files[0]);
}
</script>

@include('admin.courses.partials.dynamic-list-script')

@endsection

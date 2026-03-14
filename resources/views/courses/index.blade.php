@extends('layouts.app')
@section('title', 'All Courses | AsproHubs')
@section('meta_description', 'Browse all professional courses on AsproHubs.')

@section('content')

{{-- ── Hero Header ── --}}
<div class="bg-[var(--aspro-dark)] py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-extrabold text-white">Browse All Courses</h1>
        <p class="mt-3 text-lg text-slate-300 max-w-xl mx-auto">
            Expert-led professional courses designed to grow your career.
        </p>

        {{-- Search bar --}}
        <form method="GET" action="{{ route('courses.index') }}" class="mt-8 max-w-lg mx-auto">
            <div class="flex items-center gap-2 rounded-2xl bg-white/10 border border-white/20
                        px-4 py-2 focus-within:border-[var(--aspro-primary)]">
                <svg class="h-5 w-5 text-white/50 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search courses…"
                    class="flex-1 bg-transparent text-white placeholder-white/50 text-sm focus:outline-none"
                />
                <button type="submit"
                        class="rounded-xl px-4 py-1.5 text-sm font-bold text-white transition flex-shrink-0
                               bg-[var(--aspro-primary)] hover:bg-[var(--aspro-primary-dark)]">
                    Search
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── Main: Filters + Grid ── --}}
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col lg:flex-row gap-10">

        {{-- ── Sidebar Filters ── --}}
        <aside class="lg:w-56 flex-shrink-0">
            <form method="GET" action="{{ route('courses.index') }}" id="filterForm">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                {{-- Category --}}
                <div class="mb-7">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">Category</h3>
                    <div class="space-y-2">
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="radio" name="category" value=""
                                   {{ !request('category') ? 'checked' : '' }}
                                   onchange="this.form.submit()"
                                   class="text-[var(--aspro-primary)] focus:ring-[var(--aspro-primary)]" />
                            <span class="text-sm text-gray-700 group-hover:text-[var(--aspro-primary)] transition">All</span>
                        </label>
                        @foreach($categories as $cat)
                        <label class="flex items-center justify-between gap-2 cursor-pointer group">
                            <div class="flex items-center gap-2.5">
                                <input type="radio" name="category" value="{{ $cat->slug }}"
                                       {{ request('category') === $cat->slug ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       class="text-[var(--aspro-primary)] focus:ring-[var(--aspro-primary)]" />
                                <span class="text-sm text-gray-700 group-hover:text-[var(--aspro-primary)] transition">
                                    {{ $cat->name }}
                                </span>
                            </div>
                            <span class="text-xs text-gray-400">{{ $cat->courses_count }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Level --}}
                <div class="mb-7">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">Level</h3>
                    <div class="space-y-2">
                        @foreach(['' => 'All Levels', 'beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'] as $val => $label)
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="radio" name="level" value="{{ $val }}"
                                   {{ request('level', '') === $val ? 'checked' : '' }}
                                   onchange="this.form.submit()"
                                   class="text-[var(--aspro-primary)] focus:ring-[var(--aspro-primary)]" />
                            <span class="text-sm text-gray-700 group-hover:text-[var(--aspro-primary)] transition">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Price --}}
                <div class="mb-7">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">Price</h3>
                    <div class="space-y-2">
                        @foreach(['' => 'All', 'free' => 'Free', 'paid' => 'Paid'] as $val => $label)
                        <label class="flex items-center gap-2.5 cursor-pointer group">
                            <input type="radio" name="price" value="{{ $val }}"
                                   {{ request('price', '') === $val ? 'checked' : '' }}
                                   onchange="this.form.submit()"
                                   class="text-[var(--aspro-primary)] focus:ring-[var(--aspro-primary)]" />
                            <span class="text-sm text-gray-700 group-hover:text-[var(--aspro-primary)] transition">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                @if(request()->hasAny(['category','level','price','search']))
                <a href="{{ route('courses.index') }}"
                   class="text-sm font-semibold text-[var(--aspro-primary)] hover:underline">
                    ✕ Clear filters
                </a>
                @endif
            </form>
        </aside>

        {{-- ── Course Grid ── --}}
        <div class="flex-1">
            <p class="text-sm text-gray-500 mb-6">
                <span class="font-bold text-gray-900">{{ $courses->total() }}</span>
                course{{ $courses->total() !== 1 ? 's' : '' }} found
            </p>

            @if($courses->isEmpty())
                <div class="text-center py-24">
                    <p class="text-5xl mb-4">🔍</p>
                    <h3 class="text-lg font-bold text-gray-900">No courses found</h3>
                    <p class="text-sm text-gray-500 mt-1">Try adjusting your search or filters.</p>
                    <a href="{{ route('courses.index') }}"
                       class="mt-5 inline-block rounded-xl px-6 py-2.5 text-sm font-bold text-white
                              bg-[var(--aspro-primary)] hover:bg-[var(--aspro-primary-dark)] transition">
                        Clear Filters
                    </a>
                </div>
            @else
                <div class="grid gap-7 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($courses as $course)
                    <a href="{{ route('courses.show', $course->slug) }}"
                       class="group flex flex-col rounded-2xl border border-gray-200 bg-white overflow-hidden
                              hover:shadow-xl hover:border-[var(--aspro-primary)] transition-all duration-300">

                        {{-- Thumbnail --}}
                        <div class="h-48 overflow-hidden bg-[var(--aspro-light)] flex-shrink-0">
                            @if($course->thumbnail)
                                <img src="{{ $course->thumbnail_url }}"
                                     alt="{{ $course->title }}"
                                     class="h-full w-full object-cover group-hover:scale-105 transition duration-500" />
                            @else
                                <div class="h-full w-full flex items-center justify-center
                                            bg-gradient-to-br from-[var(--aspro-primary-light)] to-white">
                                    <svg class="h-12 w-12 text-[var(--aspro-primary)] opacity-30"
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Card body --}}
                        <div class="flex flex-1 flex-col p-5">
                            @if($course->category)
                            <span class="inline-block self-start rounded-full px-2.5 py-0.5 text-[11px]
                                         font-semibold mb-2
                                         bg-[var(--aspro-primary-light)] text-[var(--aspro-primary)]">
                                {{ $course->category->name }}
                            </span>
                            @endif

                            <h3 class="font-bold text-gray-900 leading-snug line-clamp-2
                                       group-hover:text-[var(--aspro-primary)] transition">
                                {{ $course->title }}
                            </h3>

                            @if($course->subtitle)
                            <p class="mt-1.5 text-xs text-gray-500 line-clamp-2">{{ $course->subtitle }}</p>
                            @endif

                            <div class="mt-auto pt-4 flex items-center justify-between border-t border-gray-100">
                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                    @if($course->duration_weeks)
                                    <span>{{ $course->duration_weeks }}w</span>
                                    @endif
                                    <span class="capitalize">{{ $course->level }}</span>
                                </div>
                                <span class="font-bold text-[var(--aspro-primary)]">
                                    {{ $course->formatted_price }}
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                @if($courses->hasPages())
                <div class="mt-10">
                    {{ $courses->links() }}
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

@endsection
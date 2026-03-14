@extends('layouts.app')
@section('title', $course->title . ' | AsproHubs')
@section('meta_description', $course->subtitle ?? $course->title)

@section('content')

{{-- ══════════════════════════════════════════════════════
     COURSE HERO
══════════════════════════════════════════════════════ --}}
<div class="relative bg-[var(--aspro-dark)] py-14 overflow-hidden">

    {{-- Subtle background thumbnail blur --}}
    @if($course->thumbnail)
    <div class="absolute inset-0 opacity-10"
         style="background: url('{{ $course->thumbnail_url }}') center/cover no-repeat;"></div>
    <div class="absolute inset-0 bg-[var(--aspro-dark)]/90"></div>
    @endif

    <div class="relative max-w-7xl mx-auto px-6">
        <div class="lg:max-w-3xl">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <span>›</span>
                <a href="{{ route('courses.index') }}" class="hover:text-white transition">Courses</a>
                @if($course->category)
                <span>›</span>
                <a href="{{ route('courses.index', ['category' => $course->category->slug]) }}"
                   class="hover:text-white transition">{{ $course->category->name }}</a>
                @endif
                <span>›</span>
                <span class="text-white truncate max-w-[200px]">{{ $course->title }}</span>
            </nav>

            {{-- Category badge --}}
            @if($course->category)
            <span class="inline-block rounded-full px-3 py-1 text-xs font-bold mb-4
                         bg-[var(--aspro-primary-light)] text-[var(--aspro-primary)]">
                {{ $course->category->name }}
            </span>
            @endif

            <h1 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">
                {{ $course->title }}
            </h1>

            @if($course->subtitle)
            <p class="mt-3 text-lg text-slate-300">{{ $course->subtitle }}</p>
            @endif

            {{-- Quick meta --}}
            <div class="mt-6 flex flex-wrap items-center gap-5 text-sm text-slate-400">
                @if($course->level)
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    {{ ucfirst($course->level) }}
                </span>
                @endif
                @if($course->duration_weeks)
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $course->duration_weeks }} weeks
                </span>
                @endif
                @if($course->mode)
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $course->mode }}
                </span>
                @endif
                @if($course->language)
                <span class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    {{ $course->language }}
                </span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     BODY — 2 COLUMNS: Content + Enrollment Card
══════════════════════════════════════════════════════ --}}
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="flex flex-col lg:flex-row gap-12">

        {{-- ────────────── LEFT: Course Info ────────────── --}}
        <div class="flex-1 min-w-0">

            {{-- Description --}}
            <section class="mb-10">
                <h2 class="text-xl font-extrabold text-gray-900 mb-4">About This Course</h2>
                <div class="prose max-w-none text-gray-600 leading-relaxed">
                    {!! nl2br(e($course->description)) !!}
                </div>
            </section>

            {{-- What you'll learn --}}
            @if($course->what_you_will_learn && count($course->what_you_will_learn))
            <section class="mb-10 rounded-2xl border border-[var(--aspro-border)] bg-[var(--aspro-light)] p-6">
                <h2 class="text-xl font-extrabold text-gray-900 mb-5">What You'll Learn</h2>
                <div class="grid sm:grid-cols-2 gap-3">
                    @foreach($course->what_you_will_learn as $item)
                    <div class="flex items-start gap-2.5 text-sm text-gray-700">
                        <span class="mt-0.5 flex-shrink-0 font-bold text-[var(--aspro-primary)]">✓</span>
                        {{ $item }}
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Requirements --}}
            @if($course->requirements && count($course->requirements))
            <section class="mb-10">
                <h2 class="text-xl font-extrabold text-gray-900 mb-4">Requirements</h2>
                <ul class="space-y-2">
                    @foreach($course->requirements as $req)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <span class="mt-1 h-1.5 w-1.5 rounded-full bg-[var(--aspro-primary)] flex-shrink-0"></span>
                        {{ $req }}
                    </li>
                    @endforeach
                </ul>
            </section>
            @endif

            {{-- Who it's for --}}
            @if($course->who_course_is_for && count($course->who_course_is_for))
            <section class="mb-10">
                <h2 class="text-xl font-extrabold text-gray-900 mb-4">Who This Course Is For</h2>
                <ul class="space-y-2">
                    @foreach($course->who_course_is_for as $who)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <span class="mt-0.5 flex-shrink-0 font-bold text-[var(--aspro-primary)]">→</span>
                        {{ $who }}
                    </li>
                    @endforeach
                </ul>
            </section>
            @endif

        </div>

        {{-- ────────────── RIGHT: Enrollment Card ────────────── --}}
        <aside class="lg:w-80 flex-shrink-0">
            <div class="sticky top-20" x-data="{ panel: 'info' }">

                {{-- Course image --}}
                @if($course->thumbnail)
                <div class="rounded-2xl overflow-hidden mb-5 shadow-md">
                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}"
                         class="w-full h-48 object-cover" />
                </div>
                @endif

                {{-- Enrollment card --}}
                <div class="rounded-2xl border border-[var(--aspro-border)] bg-white shadow-lg overflow-hidden">

                    {{-- Price header --}}
                    <div class="px-6 pt-6 pb-4">
                        <div class="flex items-end gap-3">
                            <span class="text-3xl font-extrabold text-[var(--aspro-primary)]">
                                {{ $course->formatted_price }}
                            </span>
                            @if($course->discount_price && $course->price > $course->discount_price)
                            <span class="text-sm text-gray-400 line-through mb-1">
                                ₦{{ number_format($course->price) }}
                            </span>
                            @endif
                        </div>

                        @if($course->schedule)
                        <p class="mt-1 text-sm text-gray-500">
                            <span class="font-medium">Schedule:</span> {{ $course->schedule }}
                        </p>
                        @endif
                    </div>

                    <div class="px-6 pb-6">

                        {{-- ══ STATE 1: Already enrolled ══ --}}
                        @if($enrollment)
                            @php
                            $colors = [
                                'pending'   => ['bg'=>'amber',   'label'=>'Under Review'],
                                'approved'  => ['bg'=>'emerald', 'label'=>'Approved — You\'re In!'],
                                'rejected'  => ['bg'=>'red',     'label'=>'Not Approved'],
                                'cancelled' => ['bg'=>'gray',    'label'=>'Cancelled'],
                                'completed' => ['bg'=>'blue',    'label'=>'Completed'],
                            ];
                            $s = $colors[$enrollment->status] ?? ['bg'=>'gray','label'=>ucfirst($enrollment->status)];
                            @endphp
                            <div class="rounded-xl border-2 border-{{ $s['bg'] }}-200
                                        bg-{{ $s['bg'] }}-50 px-4 py-4 text-center">
                                <p class="text-xs font-bold uppercase tracking-wider text-{{ $s['bg'] }}-600 mb-1">
                                    Enrollment Status
                                </p>
                                <p class="font-bold text-{{ $s['bg'] }}-700">{{ $s['label'] }}</p>
                                @if($enrollment->status === 'pending')
                                <p class="text-xs text-{{ $s['bg'] }}-600 mt-1">
                                    We'll contact you within 24 hours.
                                </p>
                                @endif
                            </div>
                            <a href="{{ route('student.enrollments.show', $enrollment) }}"
                               class="mt-3 block text-center text-sm font-semibold
                                      text-[var(--aspro-primary)] hover:underline">
                                View Enrollment Details →
                            </a>

                        {{-- ══ STATE 2: Guest — show login panel ══ --}}
                        @elseif(!Auth::check())
                            <div x-data="{ view: 'prompt' }">

                                {{-- Initial CTA --}}
                                <div x-show="view === 'prompt'">
                                    <button
                                        @click="view = 'login'"
                                        class="w-full rounded-xl py-3 font-bold text-white text-sm transition
                                               bg-[var(--aspro-primary)] hover:bg-[var(--aspro-primary-dark)] shadow-md"
                                    >
                                        Enroll Now
                                    </button>
                                    <p class="mt-3 text-center text-xs text-gray-500">
                                        Sign in or register to enroll
                                    </p>
                                </div>

                                {{-- Inline login form --}}
                                <div x-show="view === 'login'" x-cloak>
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="font-bold text-gray-900 text-sm">Sign in to enroll</h3>
                                        <button @click="view = 'prompt'"
                                                class="text-xs text-gray-400 hover:text-gray-600">✕</button>
                                    </div>

                                    {{-- Validation errors for login --}}
                                    @if($errors->any() && old('_login_attempt'))
                                    <div class="mb-3 rounded-xl bg-red-50 border border-red-200 px-3 py-2 text-xs text-red-700">
                                        {{ $errors->first() }}
                                    </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}" class="space-y-3">
                                        @csrf
                                        {{-- Remember intended URL --}}
                                        <input type="hidden" name="_login_attempt" value="1">
                                        <input type="hidden" name="redirect_to"
                                               value="{{ route('courses.show', $course->slug) }}">

                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Email</label>
                                            <input
                                                type="email" name="email"
                                                value="{{ old('email') }}"
                                                required placeholder="you@email.com"
                                                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm
                                                       focus:outline-none focus:border-[var(--aspro-primary)]
                                                       focus:ring-1 focus:ring-[var(--aspro-primary)]"
                                            />
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">Password</label>
                                            <input
                                                type="password" name="password"
                                                required placeholder="••••••••"
                                                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm
                                                       focus:outline-none focus:border-[var(--aspro-primary)]
                                                       focus:ring-1 focus:ring-[var(--aspro-primary)]"
                                            />
                                        </div>
                                        <button
                                            type="submit"
                                            class="w-full rounded-xl py-2.5 text-sm font-bold text-white transition
                                                   bg-[var(--aspro-primary)] hover:bg-[var(--aspro-primary-dark)]"
                                        >
                                            Sign In & Continue
                                        </button>
                                    </form>

                                    <div class="mt-4 pt-3 border-t border-[var(--aspro-border)] text-center">
                                        <p class="text-xs text-gray-500 mb-2">Don't have an account?</p>
                                        <a href="{{ route('register') }}?redirect={{ route('courses.show', $course->slug) }}"
                                           class="inline-block w-full rounded-xl py-2.5 text-sm font-bold transition
                                                  border-2 border-[var(--aspro-primary)] text-[var(--aspro-primary)]
                                                  hover:bg-[var(--aspro-primary-light)]">
                                            Create Free Account
                                        </a>
                                    </div>
                                </div>
                            </div>

                        {{-- ══ STATE 3: Logged in — show enrollment form ══ --}}
                        @else
                            <div x-data="{ enrollOpen: false }">

                                {{-- Enroll button --}}
                                <div x-show="!enrollOpen">
                                    <button
                                        @click="enrollOpen = true"
                                        class="w-full rounded-xl py-3 font-bold text-white text-sm transition
                                               bg-[var(--aspro-primary)] hover:bg-[var(--aspro-primary-dark)] shadow-md"
                                    >
                                        Enroll Now
                                    </button>
                                    <p class="mt-2 text-center text-xs text-gray-500">
                                        Logged in as <span class="font-semibold">{{ auth()->user()->name }}</span>
                                    </p>
                                </div>

                                {{-- Enrollment form --}}
                                <div x-show="enrollOpen" x-cloak>
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="font-bold text-gray-900 text-sm">Complete Your Application</h3>
                                        <button @click="enrollOpen = false"
                                                class="text-xs text-gray-400 hover:text-gray-600 flex-shrink-0">✕</button>
                                    </div>

                                    @if($errors->any() && !old('_login_attempt'))
                                    <div class="mb-3 rounded-xl bg-red-50 border border-red-200 px-3 py-2 text-xs text-red-700">
                                        @foreach($errors->all() as $error)
                                        <p>• {{ $error }}</p>
                                        @endforeach
                                    </div>
                                    @endif

                                    <form method="POST"
                                          action="{{ route('courses.enroll', $course->slug) }}"
                                          class="space-y-4"
                                          x-init="enrollOpen = {{ $errors->any() && !old('_login_attempt') ? 'true' : 'false' }}">
                                        @csrf

                                        {{-- Phone --}}
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                                Phone Number <span class="text-red-500">*</span>
                                            </label>
                                            <input
                                                type="tel" name="phone"
                                                value="{{ old('phone', auth()->user()->phone) }}"
                                                required placeholder="+234 800 000 0000"
                                                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm
                                                       focus:outline-none focus:border-[var(--aspro-primary)]
                                                       focus:ring-1 focus:ring-[var(--aspro-primary)]
                                                       @error('phone') border-red-400 bg-red-50 @enderror"
                                            />
                                        </div>

                                        {{-- Company + Job title --}}
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-700 mb-1">Company</label>
                                                <input type="text" name="company"
                                                       value="{{ old('company') }}"
                                                       placeholder="Optional"
                                                       class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm
                                                              focus:outline-none focus:border-[var(--aspro-primary)]
                                                              focus:ring-1 focus:ring-[var(--aspro-primary)]" />
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-700 mb-1">Job Title</label>
                                                <input type="text" name="job_title"
                                                       value="{{ old('job_title') }}"
                                                       placeholder="Optional"
                                                       class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm
                                                              focus:outline-none focus:border-[var(--aspro-primary)]
                                                              focus:ring-1 focus:ring-[var(--aspro-primary)]" />
                                            </div>
                                        </div>

                                        {{-- Experience --}}
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                                Your current experience level <span class="text-red-500">*</span>
                                            </label>
                                            <input
                                                type="text" name="experience"
                                                value="{{ old('experience') }}"
                                                required placeholder="e.g. 2 years in project management"
                                                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm
                                                       focus:outline-none focus:border-[var(--aspro-primary)]
                                                       focus:ring-1 focus:ring-[var(--aspro-primary)]
                                                       @error('experience') border-red-400 bg-red-50 @enderror"
                                            />
                                        </div>

                                        {{-- Goals --}}
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                                What do you hope to achieve? <span class="text-red-500">*</span>
                                            </label>
                                            <textarea
                                                name="goals" rows="2" required
                                                placeholder="Your learning goals…"
                                                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm
                                                       focus:outline-none focus:border-[var(--aspro-primary)]
                                                       focus:ring-1 focus:ring-[var(--aspro-primary)] resize-none
                                                       @error('goals') border-red-400 bg-red-50 @enderror"
                                            >{{ old('goals') }}</textarea>
                                        </div>

                                        {{-- Motivation --}}
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                                Why do you want to enroll? <span class="text-red-500">*</span>
                                            </label>
                                            <textarea
                                                name="motivation" rows="3" required
                                                placeholder="Tell us your motivation (min. 20 characters)…"
                                                class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm
                                                       focus:outline-none focus:border-[var(--aspro-primary)]
                                                       focus:ring-1 focus:ring-[var(--aspro-primary)] resize-none
                                                       @error('motivation') border-red-400 bg-red-50 @enderror"
                                            >{{ old('motivation') }}</textarea>
                                        </div>

                                        {{-- How did you hear --}}
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-700 mb-1">
                                                How did you hear about us?
                                            </label>
                                            <select name="how_did_you_hear"
                                                    class="w-full rounded-xl border border-gray-300 px-3 py-2.5 text-sm
                                                           focus:outline-none focus:border-[var(--aspro-primary)]
                                                           focus:ring-1 focus:ring-[var(--aspro-primary)]">
                                                <option value="">— select —</option>
                                                @foreach(['Google', 'Social Media', 'Friend/Colleague', 'Email Newsletter', 'LinkedIn', 'Other'] as $src)
                                                <option value="{{ $src }}" {{ old('how_did_you_hear') === $src ? 'selected' : '' }}>
                                                    {{ $src }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <button
                                            type="submit"
                                            class="w-full rounded-xl py-3 text-sm font-bold text-white transition
                                                   bg-[var(--aspro-primary)] hover:bg-[var(--aspro-primary-dark)] shadow-md"
                                        >
                                            Submit Application
                                        </button>
                                        <p class="text-center text-xs text-gray-400">
                                            We'll review and contact you within 24 hours.
                                        </p>
                                    </form>
                                </div>
                            </div>
                        @endif

                    </div>{{-- /card body --}}

                    {{-- Course highlights --}}
                    <div class="border-t border-[var(--aspro-border)] px-6 py-4 space-y-2.5 bg-[var(--aspro-light)]">
                        @if($course->duration_weeks)
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="h-4 w-4 text-[var(--aspro-primary)] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ $course->duration_weeks }} week duration</span>
                        </div>
                        @endif
                        @if($course->mode)
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="h-4 w-4 text-[var(--aspro-primary)] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ $course->mode }}</span>
                        </div>
                        @endif
                        @if($course->language)
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="h-4 w-4 text-[var(--aspro-primary)] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                            </svg>
                            <span>{{ $course->language }}</span>
                        </div>
                        @endif
                        @if($course->level)
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <svg class="h-4 w-4 text-[var(--aspro-primary)] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span>{{ ucfirst($course->level) }} level</span>
                        </div>
                        @endif
                    </div>

                </div>{{-- /enrollment card --}}
            </div>{{-- /sticky --}}
        </aside>

    </div>{{-- /flex --}}
</div>

{{-- ══════════════════════════════════════════════════════
     RELATED COURSES
══════════════════════════════════════════════════════ --}}
@if($related->isNotEmpty())
<section class="bg-[var(--aspro-light)] py-14">
    <div class="max-w-7xl mx-auto px-6">
        <h2 class="text-2xl font-extrabold text-gray-900 mb-8">Related Courses</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($related as $r)
            <a href="{{ route('courses.show', $r->slug) }}"
               class="group flex flex-col rounded-2xl border border-gray-200 bg-white overflow-hidden
                      hover:shadow-lg hover:border-[var(--aspro-primary)] transition-all duration-300">
                <div class="h-36 overflow-hidden bg-[var(--aspro-light)]">
                    @if($r->thumbnail)
                    <img src="{{ $r->thumbnail_url }}" alt="{{ $r->title }}"
                         class="h-full w-full object-cover group-hover:scale-105 transition duration-500"/>
                    @else
                    <div class="h-full flex items-center justify-center
                                bg-gradient-to-br from-[var(--aspro-primary-light)] to-white">
                        <svg class="h-10 w-10 text-[var(--aspro-primary)] opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 line-clamp-2 group-hover:text-[var(--aspro-primary)] transition">
                        {{ $r->title }}
                    </h3>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-xs text-gray-500 capitalize">{{ $r->level }}</span>
                        <span class="font-bold text-sm text-[var(--aspro-primary)]">
                            {{ $r->formatted_price }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Re-open enrollment form if there were validation errors --}}
@push('scripts')
<script>
    // If errors exist from enrollment form, auto-open the panel
    @if($errors->any() && !old('_login_attempt') && Auth::check())
        document.addEventListener('alpine:init', () => {
            // The x-init on the form already handles this via the ternary
        });
    @endif
</script>
@endpush

@endsection
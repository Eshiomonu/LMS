@extends('layouts.student')
@section('title', 'My Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Welcome Banner --}}
<div class="relative mb-8 overflow-hidden rounded-2xl p-7 text-white"
     style="background: linear-gradient(135deg, var(--aspro-primary) 0%, #7c3aed 100%);">
    <div class="pointer-events-none absolute -right-8 -top-8 h-44 w-44 rounded-full bg-white/5"></div>
    <div class="pointer-events-none absolute -bottom-10 right-24 h-32 w-32 rounded-full bg-white/5"></div>
    <div class="relative z-10">
        <p class="text-sm font-medium text-indigo-200">Welcome back 👋</p>
        <h2 class="mt-0.5 text-2xl font-extrabold">{{ $user->name }}</h2>
        <p class="mt-1 max-w-md text-sm text-indigo-200">
            Keep going — every course you complete opens a new door.
        </p>
        <a href="{{ route('courses.index') }}"
           class="mt-5 inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5
                  text-sm font-bold shadow-md hover:bg-indigo-50 transition"
           style="color: var(--aspro-primary);">
            Browse Courses
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>

{{-- Stat Cards --}}
<div class="mb-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
    @php
    $cards = [
        ['label' => 'Total Enrolled', 'value' => $stats['total_enrolled'], 'icon' => '📚', 'color' => '#4f46e5'],
        ['label' => 'Approved',       'value' => $stats['active'],         'icon' => '✅', 'color' => '#059669'],
        ['label' => 'Pending Review', 'value' => $stats['pending'],        'icon' => '⏳', 'color' => '#d97706'],
        ['label' => 'Completed',      'value' => $stats['completed'],      'icon' => '🎓', 'color' => '#7c3aed'],
    ];
    @endphp
    @foreach($cards as $card)
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-semibold text-slate-500">{{ $card['label'] }}</p>
            <span class="text-xl">{{ $card['icon'] }}</span>
        </div>
        <p class="text-3xl font-extrabold" style="color:{{ $card['color'] }};font-family:'Syne',sans-serif;">
            {{ $card['value'] }}
        </p>
    </div>
    @endforeach
</div>

{{-- Recent Enrollments --}}
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">

    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">Recent Enrollments</h3>
        <a href="{{ route('student.enrollments.index') }}"
           class="text-sm font-semibold hover:underline" style="color:var(--aspro-primary)">View all →</a>
    </div>

    @if($recent->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center px-6">
            <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl"
                 style="background:var(--aspro-primary-light)">
                <svg class="h-8 w-8" style="color:var(--aspro-primary)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="font-bold text-slate-700">No enrollments yet</p>
            <p class="mt-1 text-sm text-slate-400 max-w-xs">Browse our courses and apply to get started on your learning journey.</p>
            <a href="{{ route('courses.index') }}"
               class="mt-5 rounded-xl px-6 py-2.5 text-sm font-bold text-white shadow-sm"
               style="background:var(--aspro-primary)">Browse Courses</a>
        </div>
    @else
        <div class="divide-y divide-slate-100">
            @foreach($recent as $enr)
            @php
                $sc = match($enr->status) {
                    'approved'  => ['#d1fae5','#065f46'],
                    'pending'   => ['#fef3c7','#92400e'],
                    'rejected'  => ['#fee2e2','#991b1b'],
                    'completed' => ['#dbeafe','#1e40af'],
                    default     => ['#f1f5f9','#475569'],
                };
            @endphp
            <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition">
                <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-xl"
                     style="background:var(--aspro-primary-light)">
                    @if($enr->course?->thumbnail)
                        <img src="{{ $enr->course->thumbnail_url }}" alt="{{ $enr->course->title }}"
                             class="h-full w-full object-cover"/>
                    @else
                        <div class="flex h-full w-full items-center justify-center text-xl">📚</div>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-slate-900">{{ $enr->course->title ?? '—' }}</p>
                    <p class="mt-0.5 text-xs text-slate-400">Applied {{ $enr->created_at->format('M d, Y') }}</p>
                </div>
                <div class="flex flex-shrink-0 flex-col items-end gap-1.5">
                    <span class="rounded-full px-2.5 py-0.5 text-xs font-bold"
                          style="background:{{ $sc[0] }};color:{{ $sc[1] }}">
                        {{ ucfirst($enr->status) }}
                    </span>
                    <a href="{{ route('student.enrollments.show', $enr) }}"
                       class="text-xs font-semibold hover:underline" style="color:var(--aspro-primary)">Details →</a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
@extends('layouts.student')
@section('title', 'My Enrollments')
@section('page-title', 'My Enrollments')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">All Enrollments</h2>
        <p class="mt-0.5 text-sm text-slate-500">Track the status of all your course applications</p>
    </div>
    <a href="{{ route('courses.index') }}"
       class="rounded-xl px-4 py-2.5 text-sm font-bold text-white shadow-sm transition"
       style="background:var(--aspro-primary)">+ Find a Course</a>
</div>

{{-- Status filter tabs --}}
@php
$tab    = request('status', 'all');
$tabs   = ['all'=>'All','pending'=>'Pending','approved'=>'Approved','completed'=>'Completed','rejected'=>'Rejected'];
$counts = [
    'all'       => $enrollments->count(),
    'pending'   => $enrollments->where('status','pending')->count(),
    'approved'  => $enrollments->where('status','approved')->count(),
    'completed' => $enrollments->where('status','completed')->count(),
    'rejected'  => $enrollments->where('status','rejected')->count(),
];
$filtered = $tab === 'all' ? $enrollments : $enrollments->where('status', $tab);
@endphp

<div class="mb-6 flex flex-wrap gap-2">
    @foreach($tabs as $key => $label)
    <a href="{{ route('student.enrollments.index', ['status' => $key]) }}"
       class="rounded-xl border px-4 py-1.5 text-sm font-semibold transition"
       style="{{ $tab === $key
           ? 'background:var(--aspro-primary);color:#fff;border-color:transparent'
           : 'background:#fff;color:#475569;border-color:#e2e8f0' }}">
        {{ $label }}
        <span class="ml-1 opacity-60 text-xs">({{ $counts[$key] }})</span>
    </a>
    @endforeach
</div>

@if($filtered->isEmpty())
    <div class="rounded-2xl border border-slate-200 bg-white py-20 text-center">
        <p class="text-4xl mb-4">📋</p>
        <p class="font-bold text-slate-700">No {{ $tab !== 'all' ? $tab : '' }} enrollments</p>
        <p class="text-sm text-slate-400 mt-1">
            {{ $tab === 'all' ? "You haven't applied to any course yet." : 'No enrollments with this status.' }}
        </p>
        @if($tab === 'all')
            <a href="{{ route('courses.index') }}"
               class="mt-5 inline-block rounded-xl px-6 py-2.5 text-sm font-bold text-white"
               style="background:var(--aspro-primary)">Browse Courses</a>
        @endif
    </div>
@else
    <div class="space-y-4">
        @foreach($filtered as $enr)
        @php
            $sc = match($enr->status) {
                'approved'  => ['#d1fae5','#065f46'],
                'pending'   => ['#fef3c7','#92400e'],
                'rejected'  => ['#fee2e2','#991b1b'],
                'completed' => ['#dbeafe','#1e40af'],
                default     => ['#f1f5f9','#475569'],
            };
        @endphp
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm
                    hover:border-[var(--aspro-primary)] transition">
            <div class="flex items-start gap-4">
                <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-xl"
                     style="background:var(--aspro-primary-light)">
                    @if($enr->course?->thumbnail)
                        <img src="{{ $enr->course->thumbnail_url }}" alt="{{ $enr->course->title }}"
                             class="h-full w-full object-cover"/>
                    @else
                        <div class="flex h-full w-full items-center justify-center text-2xl">📚</div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-3 flex-wrap">
                        <div>
                            <h3 class="font-bold text-slate-900">{{ $enr->course->title ?? '—' }}</h3>
                            <p class="text-sm text-slate-500 mt-0.5">
                                {{ $enr->course?->category?->name }}
                                @if($enr->course?->mode) · {{ $enr->course->mode }} @endif
                                @if($enr->course?->duration_weeks) · {{ $enr->course->duration_weeks }}w @endif
                            </p>
                        </div>
                        <span class="flex-shrink-0 rounded-full px-3 py-1 text-xs font-bold"
                              style="background:{{ $sc[0] }};color:{{ $sc[1] }}">
                            {{ ucfirst($enr->status) }}
                        </span>
                    </div>
                    <div class="mt-3 flex flex-wrap items-center gap-4 text-xs text-slate-400">
                        <span>Applied {{ $enr->created_at->format('M d, Y') }}</span>
                        @if($enr->approved_at)
                            <span>Approved {{ $enr->approved_at->format('M d, Y') }}</span>
                        @endif
                        @if($enr->amount_paid)
                            <span class="font-semibold" style="color:var(--aspro-primary)">
                                {{ $enr->currency }} {{ number_format($enr->amount_paid) }}
                            </span>
                        @endif
                    </div>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('student.enrollments.show', $enr) }}"
                           class="rounded-lg px-4 py-1.5 text-xs font-bold text-white"
                           style="background:var(--aspro-primary)">View Details</a>
                        @if($enr->course)
                        <a href="{{ route('courses.show', $enr->course->slug) }}"
                           class="rounded-lg border border-slate-200 px-4 py-1.5 text-xs font-semibold
                                  text-slate-600 hover:border-[var(--aspro-primary)]
                                  hover:text-[var(--aspro-primary)] transition">View Course</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
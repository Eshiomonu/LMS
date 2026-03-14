@extends('layouts.student')
@section('title', 'Enrollment Details')
@section('page-title', 'Enrollment Details')

@section('content')

@php
$sc = match($enrollment->status) {
    'approved'  => ['#d1fae5','#065f46'],
    'pending'   => ['#fef3c7','#92400e'],
    'rejected'  => ['#fee2e2','#991b1b'],
    'completed' => ['#dbeafe','#1e40af'],
    default     => ['#f1f5f9','#475569'],
};
@endphp

{{-- Back --}}
<div class="mb-6">
    <a href="{{ route('student.enrollments.index') }}"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-900 transition">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Enrollments
    </a>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- ── Left col ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Course card --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-xl"
                     style="background:var(--aspro-primary-light)">
                    @if($enrollment->course?->thumbnail)
                        <img src="{{ $enrollment->course->thumbnail_url }}"
                             alt="{{ $enrollment->course->title }}"
                             class="h-full w-full object-cover"/>
                    @else
                        <div class="flex h-full w-full items-center justify-center text-3xl">📚</div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <span class="inline-block rounded-full px-2.5 py-0.5 text-xs font-bold mb-2"
                          style="background:{{ $sc[0] }};color:{{ $sc[1] }}">
                        {{ ucfirst($enrollment->status) }}
                    </span>
                    <h2 class="font-extrabold text-slate-900 text-lg leading-snug"
                        style="font-family:'Syne',sans-serif;">
                        {{ $enrollment->course->title ?? '—' }}
                    </h2>
                    <p class="text-sm text-slate-500 mt-0.5">
                        {{ $enrollment->course?->category?->name }}
                        @if($enrollment->course?->mode) · {{ $enrollment->course->mode }} @endif
                    </p>
                    @if($enrollment->course)
                    <a href="{{ route('courses.show', $enrollment->course->slug) }}"
                       class="mt-2 inline-block text-sm font-semibold hover:underline"
                       style="color:var(--aspro-primary)">View Course Page →</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Status timeline --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-6 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Application Timeline
            </h3>
            @php
            $steps = [
                ['label' => 'Application Submitted',   'date' => $enrollment->created_at,  'done' => true],
                ['label' => 'Under Review',             'date' => null,                     'done' => in_array($enrollment->status,['pending','approved','rejected','completed'])],
                ['label' => 'Decision Made',            'date' => $enrollment->approved_at, 'done' => in_array($enrollment->status,['approved','rejected','completed'])],
                ['label' => 'Course Access Granted',   'date' => $enrollment->approved_at, 'done' => in_array($enrollment->status,['approved','completed'])],
            ];
            @endphp
            <div class="space-y-1">
                @foreach($steps as $step)
                <div class="flex items-start gap-4">
                    <div class="flex flex-col items-center">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full"
                             style="{{ $step['done'] ? 'background:var(--aspro-primary)' : 'background:#f1f5f9' }}">
                            @if($step['done'])
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <div class="h-2 w-2 rounded-full bg-slate-300"></div>
                            @endif
                        </div>
                        @if(!$loop->last)
                            <div class="my-1 h-7 w-0.5"
                                 style="{{ $step['done'] ? 'background:var(--aspro-primary)' : 'background:#e2e8f0' }}"></div>
                        @endif
                    </div>
                    <div class="pb-2 pt-1">
                        <p class="text-sm font-semibold {{ $step['done'] ? 'text-slate-900' : 'text-slate-400' }}">
                            {{ $step['label'] }}
                        </p>
                        @if($step['date'])
                            <p class="text-xs text-slate-400 mt-0.5">{{ $step['date']->format('M d, Y · g:i A') }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @if($enrollment->status === 'rejected' && $enrollment->rejection_reason)
            <div class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                <p class="text-sm font-bold text-red-700 mb-1">Reason for rejection:</p>
                <p class="text-sm text-red-600">{{ $enrollment->rejection_reason }}</p>
            </div>
            @endif

            @if($enrollment->admin_notes)
            <div class="mt-4 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3">
                <p class="text-sm font-bold text-blue-700 mb-1">Note from Admin:</p>
                <p class="text-sm text-blue-600">{{ $enrollment->admin_notes }}</p>
            </div>
            @endif
        </div>

        {{-- Application responses --}}
        @if($enrollment->enrollment_form)
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-5 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Your Application Responses
            </h3>
            @php
            $labels = [
                'motivation'       => 'Why you want to enroll',
                'experience'       => 'Your experience level',
                'goals'            => 'What you hope to achieve',
                'phone'            => 'Phone number',
                'company'          => 'Company',
                'job_title'        => 'Job title',
                'how_did_you_hear' => 'How you heard about us',
            ];
            @endphp
            <div class="divide-y divide-slate-100">
                @foreach($labels as $key => $label)
                    @if(!empty($enrollment->enrollment_form[$key]))
                    <div class="py-4 first:pt-0 last:pb-0">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">{{ $label }}</p>
                        <p class="text-sm text-slate-700">{{ $enrollment->enrollment_form[$key] }}</p>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- ── Right col ── --}}
    <div class="space-y-5">

        {{-- Summary --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">Summary</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500">Status</dt>
                    <dd><span class="rounded-full px-2.5 py-0.5 text-xs font-bold"
                              style="background:{{ $sc[0] }};color:{{ $sc[1] }}">
                        {{ ucfirst($enrollment->status) }}
                    </span></dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Applied on</dt>
                    <dd class="font-medium text-slate-900">{{ $enrollment->created_at->format('M d, Y') }}</dd>
                </div>
                @if($enrollment->amount_paid)
                <div class="flex justify-between">
                    <dt class="text-slate-500">Course Fee</dt>
                    <dd class="font-bold" style="color:var(--aspro-primary)">
                        {{ $enrollment->currency }} {{ number_format($enrollment->amount_paid) }}
                    </dd>
                </div>
                @endif
                <div class="flex justify-between">
                    <dt class="text-slate-500">Payment</dt>
                    <dd class="font-medium text-slate-900 capitalize">{{ $enrollment->payment_status }}</dd>
                </div>
            </dl>
        </div>

        {{-- Help --}}
        <div class="rounded-2xl border border-[var(--aspro-border)] p-5"
             style="background:var(--aspro-primary-light)">
            <h4 class="mb-2 text-sm font-bold" style="color:var(--aspro-primary)">Need help?</h4>
            <p class="text-xs leading-relaxed text-slate-600">
                Questions about your enrollment? Contact our support team — we respond within one business day.
            </p>
            <a href="mailto:support@asprohubs.com"
               class="mt-3 inline-block text-xs font-bold hover:underline"
               style="color:var(--aspro-primary)">Contact Support →</a>
        </div>

    </div>
</div>

@endsection
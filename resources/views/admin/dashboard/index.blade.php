@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back — here\'s your platform overview')

@section('header-actions')
<a href="{{ route('admin.courses.create') }}"
   class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-bold text-white
          shadow-sm transition hover:opacity-90 active:scale-[0.98]"
   style="background: var(--brand)">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    New Course
</a>
@endsection

@section('content')

{{-- ══ STAT CARDS ══ --}}
<div class="grid grid-cols-2 gap-4 lg:grid-cols-4 mb-7">

    @php
    $statCards = [
        [
            'label'   => 'Total Courses',
            'value'   => $stats['total_courses'],
            'sub'     => $stats['published_courses'].' published · '.$stats['draft_courses'].' drafts',
            'color'   => '#4f46e5',
            'bg'      => '#eef2ff',
            'route'   => 'admin.courses.index',
            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
        ],
        [
            'label'   => 'Total Students',
            'value'   => $stats['total_students'],
            'sub'     => '+'.$stats['new_students_week'].' this week',
            'color'   => '#059669',
            'bg'      => '#ecfdf5',
            'route'   => 'admin.users.index',
            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
        ],
        [
            'label'   => 'All Enrollments',
            'value'   => $stats['total_enrollments'],
            'sub'     => $stats['approved_enrollments'].' approved',
            'color'   => '#7c3aed',
            'bg'      => '#f5f3ff',
            'route'   => 'admin.enrollments.index',
            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>',
        ],
        [
            'label'   => 'Pending Review',
            'value'   => $stats['pending_enrollments'],
            'sub'     => $stats['pending_enrollments'] > 0 ? 'need your attention' : 'all clear!',
            'color'   => $stats['pending_enrollments'] > 0 ? '#d97706' : '#059669',
            'bg'      => $stats['pending_enrollments'] > 0 ? '#fffbeb' : '#ecfdf5',
            'route'   => 'admin.enrollments.index',
            'icon'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        ],
    ];
    @endphp

    @foreach($statCards as $card)
    <a href="{{ route($card['route']) }}"
       class="stat-card group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm
              hover:shadow-md hover:border-slate-300 transition-all duration-200">

        <div class="mb-4 flex items-start justify-between">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl"
                 style="background: {{ $card['bg'] }}">
                <svg class="w-5 h-5" style="color: {{ $card['color'] }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $card['icon'] !!}
                </svg>
            </div>
            {{-- Arrow only shows on hover --}}
            <svg class="w-4 h-4 text-slate-200 group-hover:text-slate-400 transition"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>

        <p class="text-3xl font-extrabold leading-none" style="font-family:'Syne',sans-serif; color:{{ $card['color'] }}">
            {{ number_format($card['value']) }}
        </p>
        <p class="mt-1.5 text-sm font-semibold text-slate-700">{{ $card['label'] }}</p>
        <p class="mt-0.5 text-xs text-slate-400">{{ $card['sub'] }}</p>
    </a>
    @endforeach
</div>

{{-- ══ MIDDLE ROW: trend chart + top courses ══ --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-5 mb-7">

    {{-- 7-day trend chart --}}
    <div class="lg:col-span-3 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-start justify-between">
            <div>
                <h2 class="font-extrabold text-slate-900 text-base"
                    style="font-family:'Syne',sans-serif;">Enrollment Activity</h2>
                <p class="text-xs text-slate-400 mt-0.5">New enrollments — last 7 days</p>
            </div>
            <a href="{{ route('admin.enrollments.index') }}"
               class="text-xs font-semibold hover:underline" style="color:var(--brand)">
                View all →
            </a>
        </div>

        {{-- Bar chart rendered in CSS --}}
        @php $maxVal = max(1, collect($trendDays)->max('count')); @endphp
        <div class="flex h-40 items-end gap-2">
            @foreach($trendDays as $day)
            @php
                $pct    = $day['count'] > 0 ? max(8, round(($day['count'] / $maxVal) * 100)) : 5;
                $isToday = $day['date'] === now()->format('Y-m-d');
            @endphp
            <div class="flex flex-1 flex-col items-center gap-1.5">
                {{-- Count label --}}
                <span class="text-[11px] font-semibold {{ $day['count'] > 0 ? 'text-slate-600' : 'text-slate-300' }}">
                    {{ $day['count'] > 0 ? $day['count'] : '' }}
                </span>
                {{-- Bar --}}
                <div class="w-full rounded-t-lg transition-all duration-500"
                     style="height: {{ $pct }}%;
                            background: {{ $isToday ? 'var(--brand)' : ($day['count'] > 0 ? '#c7d2fe' : '#f1f5f9') }};
                            min-height: 4px;">
                </div>
                {{-- Label --}}
                <span class="text-[10px] font-medium {{ $isToday ? 'text-indigo-600 font-bold' : 'text-slate-400' }}">
                    {{ $day['label'] }}
                </span>
            </div>
            @endforeach
        </div>

        {{-- Summary row --}}
        <div class="mt-5 grid grid-cols-3 gap-4 border-t border-slate-100 pt-5">
            @php
            $weekTotal  = collect($trendDays)->sum('count');
            $weekAvg    = round($weekTotal / 7, 1);
            $todayCount = collect($trendDays)->last()['count'];
            @endphp
            <div class="text-center">
                <p class="text-xl font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                    {{ $weekTotal }}
                </p>
                <p class="text-xs text-slate-400 mt-0.5">7-day total</p>
            </div>
            <div class="text-center border-x border-slate-100">
                <p class="text-xl font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                    {{ $weekAvg }}
                </p>
                <p class="text-xs text-slate-400 mt-0.5">daily average</p>
            </div>
            <div class="text-center">
                <p class="text-xl font-extrabold" style="font-family:'Syne',sans-serif; color:var(--brand)">
                    {{ $todayCount }}
                </p>
                <p class="text-xs text-slate-400 mt-0.5">today</p>
            </div>
        </div>
    </div>

    {{-- Top courses --}}
    <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-5 flex items-start justify-between">
            <div>
                <h2 class="font-extrabold text-slate-900 text-base"
                    style="font-family:'Syne',sans-serif;">Top Courses</h2>
                <p class="text-xs text-slate-400 mt-0.5">By enrollment count</p>
            </div>
            <a href="{{ route('admin.courses.index') }}"
               class="text-xs font-semibold hover:underline" style="color:var(--brand)">All →</a>
        </div>

        @if($topCourses->isEmpty())
        <div class="flex flex-col items-center justify-center py-10 text-center">
            <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/>
                </svg>
            </div>
            <p class="text-sm text-slate-400">No published courses yet</p>
        </div>
        @else
        <div class="space-y-4">
            @foreach($topCourses as $i => $course)
            @php
            $medals = ['#f59e0b','#94a3b8','#b45309'];
            $medalColor = $medals[$i] ?? '#6875f5';
            $maxEnr = $topCourses->first()->enrollments_count;
            $barPct = $maxEnr > 0 ? round(($course->enrollments_count / $maxEnr) * 100) : 0;
            @endphp
            <div class="flex items-center gap-3">
                <span class="flex h-6 w-6 flex-shrink-0 items-center justify-center
                             rounded-full text-[10px] font-extrabold text-white"
                      style="background: {{ $medalColor }}">
                    {{ $i + 1 }}
                </span>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-xs font-semibold text-slate-800">{{ $course->title }}</p>
                    <div class="mt-1.5 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-700"
                             style="width:{{ $barPct }}%; background: var(--brand)"></div>
                    </div>
                </div>
                <span class="flex-shrink-0 text-xs font-bold text-slate-500">
                    {{ $course->enrollments_count }}
                </span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- ══ BOTTOM ROW: recent enrollments + new students ══ --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-5">

    {{-- Recent Enrollments --}}
    <div class="lg:col-span-3 rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h2 class="font-extrabold text-slate-900 text-base"
                    style="font-family:'Syne',sans-serif;">Recent Enrollments</h2>
                <p class="text-xs text-slate-400 mt-0.5">Latest registration activity</p>
            </div>
            <a href="{{ route('admin.enrollments.index') }}"
               class="text-sm font-semibold hover:underline" style="color:var(--brand)">View all →</a>
        </div>

        @if($recentEnrollments->isEmpty())
        <div class="py-14 text-center">
            <p class="text-sm text-slate-400">No enrollments yet</p>
        </div>
        @else
        <div class="divide-y divide-slate-50">
            @foreach($recentEnrollments as $enr)
            @php
            $statusMap = [
                'pending'   => ['bg' => '#fef9c3', 'text' => '#854d0e', 'dot' => '#ca8a04', 'label' => 'Pending'],
                'approved'  => ['bg' => '#dcfce7', 'text' => '#166534', 'dot' => '#16a34a', 'label' => 'Approved'],
                'rejected'  => ['bg' => '#fee2e2', 'text' => '#991b1b', 'dot' => '#dc2626', 'label' => 'Rejected'],
                'completed' => ['bg' => '#dbeafe', 'text' => '#1e40af', 'dot' => '#2563eb', 'label' => 'Completed'],
            ];
            $s = $statusMap[$enr->status] ?? ['bg' => '#f1f5f9', 'text' => '#475569', 'dot' => '#94a3b8', 'label' => ucfirst($enr->status)];
            @endphp
            <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-slate-50/80 transition">
                {{-- Avatar initials --}}
                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full
                            text-sm font-bold text-white"
                     style="background: linear-gradient(135deg, var(--brand), #7c3aed)">
                    {{ strtoupper(substr($enr->user?->name ?? '?', 0, 2)) }}
                </div>

                {{-- Name + course --}}
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-slate-900">
                        {{ $enr->user?->name ?? '—' }}
                    </p>
                    <p class="truncate text-xs text-slate-400 mt-0.5">
                        {{ $enr->course?->title ?? '—' }}
                    </p>
                </div>

                {{-- Status + time --}}
                <div class="flex flex-shrink-0 flex-col items-end gap-1">
                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5
                                 text-[11px] font-semibold"
                          style="background:{{ $s['bg'] }};color:{{ $s['text'] }}">
                        <span class="h-1.5 w-1.5 rounded-full" style="background:{{ $s['dot'] }}"></span>
                        {{ $s['label'] }}
                    </span>
                    <span class="text-[10px] text-slate-400">{{ $enr->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- New Students --}}
    <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <h2 class="font-extrabold text-slate-900 text-base"
                    style="font-family:'Syne',sans-serif;">New Students</h2>
                <p class="text-xs text-slate-400 mt-0.5">Recently registered</p>
            </div>
            <a href="{{ route('admin.users.index') }}"
               class="text-sm font-semibold hover:underline" style="color:var(--brand)">All →</a>
        </div>

        @if($recentStudents->isEmpty())
        <div class="py-14 text-center">
            <p class="text-sm text-slate-400">No students yet</p>
        </div>
        @else
        <div class="divide-y divide-slate-50">
            @foreach($recentStudents as $student)
            @php
            $statusColors = [
                'approved'  => ['#dcfce7','#16a34a'],
                'pending'   => ['#fef9c3','#ca8a04'],
                'suspended' => ['#fee2e2','#dc2626'],
            ];
            $sc = $statusColors[$student->status] ?? ['#f1f5f9','#64748b'];
            @endphp
            <div class="flex items-center gap-3 px-6 py-3.5 hover:bg-slate-50/80 transition">
                <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full
                            text-sm font-bold text-white"
                     style="background: linear-gradient(135deg, #4f46e5, #7c3aed)">
                    {{ strtoupper(substr($student->name, 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-slate-900">{{ $student->name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ $student->email }}</p>
                </div>
                <div class="flex flex-shrink-0 flex-col items-end gap-1">
                    <span class="rounded-full px-2 py-0.5 text-[10px] font-semibold"
                          style="background:{{ $sc[0] }};color:{{ $sc[1] }}">
                        {{ ucfirst($student->status) }}
                    </span>
                    <span class="text-[10px] text-slate-400">
                        {{ $student->created_at->format('M d, Y') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>

@endsection
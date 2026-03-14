@extends('layouts.admin')
@section('title', $course->title)
@section('page-title', 'Course Detail')
@section('page-subtitle', $course->title)

@section('header-actions')
<a href="{{ route('admin.courses.edit', $course) }}"
   class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold text-white
          shadow-sm transition hover:opacity-90" style="background:var(--brand)">
    Edit Course
</a>
@if($course->status !== 'published')
<form method="POST" action="{{ route('admin.courses.publish', $course) }}" class="inline">
    @csrf
    <button type="submit"
            class="inline-flex items-center gap-2 rounded-xl border border-emerald-300 bg-emerald-50
                   px-4 py-2.5 text-sm font-bold text-emerald-700 hover:bg-emerald-100 transition">
        Publish
    </button>
</form>
@else
<form method="POST" action="{{ route('admin.courses.unpublish', $course) }}" class="inline">
    @csrf
    <button type="submit"
            class="inline-flex items-center gap-2 rounded-xl border border-amber-300 bg-amber-50
                   px-4 py-2.5 text-sm font-bold text-amber-700 hover:bg-amber-100 transition">
        Unpublish
    </button>
</form>
@endif
@endsection

@section('content')
<div class="grid grid-cols-1 gap-7 xl:grid-cols-3">

    {{-- Left: overview --}}
    <div class="xl:col-span-2 space-y-6">

        {{-- Hero card --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start">
                @if($course->thumbnail)
                <img src="{{ asset('storage/'.$course->thumbnail) }}"
                     class="w-full sm:w-48 rounded-xl object-cover flex-shrink-0"
                     style="max-height:130px" />
                @endif
                <div class="min-w-0 flex-1">
                    <div class="mb-2 flex flex-wrap gap-2">
                        @php
                        $sm = ['published'=>['#dcfce7','#166534'],'draft'=>['#fef9c3','#854d0e'],'archived'=>['#f1f5f9','#64748b'],'pending'=>['#dbeafe','#1e40af']];
                        [$sbg,$stxt] = $sm[$course->status] ?? ['#f1f5f9','#64748b'];
                        @endphp
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-bold"
                              style="background:{{ $sbg }};color:{{ $stxt }}">
                            {{ ucfirst($course->status) }}
                        </span>
                        @if($course->is_featured)
                        <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-bold text-amber-700">
                            ★ Featured
                        </span>
                        @endif
                    </div>
                    <h2 class="text-lg font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                        {{ $course->title }}
                    </h2>
                    @if($course->subtitle)
                    <p class="mt-1 text-sm text-slate-500">{{ $course->subtitle }}</p>
                    @endif
                    <div class="mt-3 flex flex-wrap gap-4 text-sm text-slate-500">
                        <span>📁 {{ $course->category?->name ?? 'Uncategorised' }}</span>
                        <span>🎯 {{ ucfirst($course->level) }}</span>
                        <span>⏱ {{ $course->duration_hours }}h</span>
                        <span>💰 ₦{{ number_format($course->price) }}</span>
                    </div>
                </div>
            </div>
            @if($course->description)
            <div class="mt-5 border-t border-slate-100 pt-5 text-sm leading-relaxed text-slate-600">
                {{ $course->description }}
            </div>
            @endif
        </div>

        {{-- What you will learn --}}
        @if($course->what_you_will_learn)
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                What You Will Learn
            </h3>
            <ul class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                @foreach((array)$course->what_you_will_learn as $item)
                <li class="flex items-start gap-2 text-sm text-slate-700">
                    <span class="mt-0.5 flex-shrink-0 text-emerald-500">✓</span> {{ $item }}
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Recent enrollments --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
                <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                    Recent Enrollments
                </h3>
                <a href="{{ route('admin.enrollments.index', ['course'=>$course->id]) }}"
                   class="text-sm font-semibold hover:underline" style="color:var(--brand)">
                    View all →
                </a>
            </div>
            @if($course->enrollments->isEmpty())
            <p class="py-10 text-center text-sm text-slate-400">No enrollments yet.</p>
            @else
            <div class="divide-y divide-slate-100">
                @foreach($course->enrollments->take(8) as $enr)
                @php $sm=['pending'=>['#fef9c3','#854d0e'],'approved'=>['#dcfce7','#166534'],'rejected'=>['#fee2e2','#991b1b'],'completed'=>['#dbeafe','#1e40af']]; [$eb,$et]=$sm[$enr->status]??['#f1f5f9','#64748b']; @endphp
                <div class="flex items-center gap-4 px-6 py-3 hover:bg-slate-50 transition">
                    <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full
                                text-xs font-bold text-white" style="background:var(--brand)">
                        {{ strtoupper(substr($enr->user?->name??'?',0,2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-slate-900">{{ $enr->user?->name }}</p>
                        <p class="text-xs text-slate-400">{{ $enr->created_at->format('M d, Y') }}</p>
                    </div>
                    <span class="rounded-full px-2.5 py-0.5 text-[11px] font-semibold"
                          style="background:{{ $eb }};color:{{ $et }}">
                        {{ ucfirst($enr->status) }}
                    </span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- Right sidebar --}}
    <div class="space-y-6">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Quick Stats
            </h3>
            <dl class="space-y-3 text-sm">
                @foreach([
                    ['Total Enrollments', $course->enrollments->count()],
                    ['Approved', $course->enrollments->where('status','approved')->count()],
                    ['Pending', $course->enrollments->where('status','pending')->count()],
                    ['Revenue', '₦'.number_format($course->enrollments->where('payment_status','paid')->sum('amount_paid'))],
                    ['Published', $course->published_at?->format('M d, Y') ?? '—'],
                    ['Created', $course->created_at->format('M d, Y')],
                ] as [$lbl,$val])
                <div class="flex justify-between">
                    <dt class="text-slate-500">{{ $lbl }}</dt>
                    <dd class="font-semibold text-slate-900">{{ $val }}</dd>
                </div>
                @endforeach
            </dl>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">Actions</h3>
            <div class="space-y-2">
                <form method="POST" action="{{ route('admin.courses.feature', $course) }}">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm
                                   font-semibold text-slate-700 hover:bg-slate-50 transition text-left">
                        {{ $course->is_featured ? '★ Remove from Featured' : '☆ Mark as Featured' }}
                    </button>
                </form>
                <a href="{{ route('courses.show', $course->slug) }}" target="_blank"
                   class="flex w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm
                          font-semibold text-slate-700 hover:bg-slate-50 transition">
                    View Public Page ↗
                </a>
                <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                      onsubmit="return confirm('Move to trash?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full rounded-xl border border-red-200 bg-red-50 px-4 py-2.5
                                   text-sm font-semibold text-red-700 hover:bg-red-100 transition text-left">
                        🗑 Move to Trash
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
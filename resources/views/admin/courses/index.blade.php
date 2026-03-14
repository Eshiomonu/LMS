@extends('layouts.admin')
@section('title', 'Courses')
@section('page-title', 'Courses')
@section('page-subtitle', $stats['total'] . ' total · ' . $stats['published'] . ' published · ' . $stats['draft'] . ' drafts')

@section('header-actions')
<a href="{{ route('admin.courses.create') }}"
   class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold text-white
          shadow-sm transition hover:opacity-90"
   style="background:var(--brand)">
    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    New Course
</a>
@endsection

@section('content')

{{-- Stat strip --}}
<div class="mb-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
    @php
    $strips = [
        ['label'=>'Total',     'val'=>$stats['total'],     'bg'=>'#eef2ff','c'=>'#4f46e5'],
        ['label'=>'Published', 'val'=>$stats['published'], 'bg'=>'#dcfce7','c'=>'#16a34a'],
        ['label'=>'Draft',     'val'=>$stats['draft'],     'bg'=>'#fef9c3','c'=>'#ca8a04'],
        ['label'=>'Archived',  'val'=>$stats['archived'],  'bg'=>'#f1f5f9','c'=>'#64748b'],
    ];
    @endphp
    @foreach($strips as $s)
    <div class="stat-card rounded-2xl border border-slate-200 bg-white p-4 shadow-sm text-center">
        <p class="text-2xl font-extrabold" style="font-family:'Syne',sans-serif;color:{{ $s['c'] }}">
            {{ $s['val'] }}
        </p>
        <p class="mt-0.5 text-xs font-semibold text-slate-500">{{ $s['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Filters --}}
<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <form method="GET" action="{{ route('admin.courses.index') }}"
          class="flex flex-wrap items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search title…"
               class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm shadow-sm
                      focus:outline-none focus:border-indigo-400 w-52" />
        <select name="status"
                class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                       focus:outline-none focus:border-indigo-400">
            <option value="">All statuses</option>
            @foreach(['draft','pending','published','archived'] as $st)
            <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
            @endforeach
        </select>
        <select name="category"
                class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                       focus:outline-none focus:border-indigo-400">
            <option value="">All categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected(request('category')==$cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit"
                class="rounded-xl px-4 py-2 text-sm font-semibold text-white"
                style="background:var(--brand)">Filter</button>
        @if(request()->hasAny(['search','status','category']))
        <a href="{{ route('admin.courses.index') }}"
           class="text-sm text-slate-400 hover:text-slate-700">Clear</a>
        @endif
    </form>
</div>

{{-- Table --}}
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50/60 text-xs font-bold uppercase
                       tracking-wider text-slate-500">
                <th class="px-6 py-3.5 text-left">Course</th>
                <th class="px-4 py-3.5 text-left hidden md:table-cell">Category</th>
                <th class="px-4 py-3.5 text-left hidden lg:table-cell">Level</th>
                <th class="px-4 py-3.5 text-right hidden sm:table-cell">Price</th>
                <th class="px-4 py-3.5 text-center hidden sm:table-cell">Enroll.</th>
                <th class="px-4 py-3.5 text-center">Status</th>
                <th class="px-4 py-3.5 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($courses as $course)
            @php
            $statusMap = [
                'published' => ['#dcfce7','#166534'],
                'draft'     => ['#fef9c3','#854d0e'],
                'archived'  => ['#f1f5f9','#64748b'],
                'pending'   => ['#dbeafe','#1e40af'],
            ];
            [$sbg,$stxt] = $statusMap[$course->status] ?? ['#f1f5f9','#64748b'];
            @endphp
            <tr class="hover:bg-slate-50/50 transition group {{ $course->trashed() ? 'opacity-50' : '' }}">
                {{-- Title + thumbnail --}}
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-14 flex-shrink-0 rounded-lg overflow-hidden bg-slate-100">
                            @if($course->thumbnail)
                            <img src="{{ asset('storage/'.$course->thumbnail) }}"
                                 class="h-full w-full object-cover" alt="" />
                            @else
                            <div class="h-full w-full flex items-center justify-center"
                                 style="background:#eef2ff">
                                <svg class="h-4 w-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13"/>
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-slate-900 max-w-[200px]">
                                {{ $course->title }}
                            </p>
                            @if($course->is_featured)
                            <span class="text-[10px] font-bold text-amber-600">★ Featured</span>
                            @endif
                            @if($course->trashed())
                            <span class="text-[10px] font-bold text-red-500">🗑 Trashed</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 hidden md:table-cell text-slate-500">
                    {{ $course->category?->name ?? '—' }}
                </td>
                <td class="px-4 py-4 hidden lg:table-cell">
                    <span class="capitalize text-slate-500">{{ $course->level }}</span>
                </td>
                <td class="px-4 py-4 text-right hidden sm:table-cell font-semibold text-slate-700">
                    ₦{{ number_format($course->price) }}
                </td>
                <td class="px-4 py-4 text-center hidden sm:table-cell text-slate-600">
                    {{ $course->enrollments_count ?? 0 }}
                </td>
                <td class="px-4 py-4 text-center">
                    <span class="rounded-full px-2.5 py-0.5 text-[11px] font-bold"
                          style="background:{{ $sbg }};color:{{ $stxt }}">
                        {{ ucfirst($course->status) }}
                    </span>
                </td>
                <td class="px-4 py-4 text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        @if(!$course->trashed())
                        <a href="{{ route('admin.courses.edit', $course) }}"
                           class="inline-flex h-8 w-8 items-center justify-center rounded-lg
                                  border border-slate-200 text-slate-500 hover:bg-indigo-50
                                  hover:text-indigo-600 hover:border-indigo-200 transition">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        {{-- Publish toggle --}}
                        @if($course->status === 'published')
                        <form method="POST" action="{{ route('admin.courses.unpublish', $course) }}">
                            @csrf
                            <button type="submit" title="Unpublish"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg
                                           border border-slate-200 text-slate-500 hover:bg-amber-50
                                           hover:text-amber-600 hover:border-amber-200 transition">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29"/>
                                </svg>
                            </button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('admin.courses.publish', $course) }}">
                            @csrf
                            <button type="submit" title="Publish"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg
                                           border border-slate-200 text-slate-500 hover:bg-emerald-50
                                           hover:text-emerald-600 hover:border-emerald-200 transition">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </form>
                        @endif
                        {{-- Delete --}}
                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                              onsubmit="return confirm('Move to trash?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex h-8 w-8 items-center justify-center rounded-lg
                                           border border-slate-200 text-slate-500 hover:bg-red-50
                                           hover:text-red-600 hover:border-red-200 transition">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('admin.courses.restore', $course->id) }}">
                            @csrf
                            <button type="submit"
                                    class="rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-1.5
                                           text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition">
                                Restore
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-16 text-center text-sm text-slate-400">
                    No courses found.
                    <a href="{{ route('admin.courses.create') }}"
                       class="ml-1 font-semibold hover:underline" style="color:var(--brand)">
                        Create the first one →
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($courses->hasPages())
    <div class="border-t border-slate-100 px-6 py-4">
        {{ $courses->links() }}
    </div>
    @endif
</div>
@endsection
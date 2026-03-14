@extends('layouts.admin')
@section('title', 'Enrollments')
@section('page-title', 'Enrollments')
@section('page-subtitle', $stats['total'] . ' total · ' . $stats['pending'] . ' pending review')

@section('content')

{{-- Stat strip --}}
<div class="mb-6 grid grid-cols-2 gap-4 sm:grid-cols-5">
    @php
    $strips = [
        ['label'=>'Total',     'val'=>$stats['total'],     'bg'=>'#eef2ff','c'=>'#4f46e5'],
        ['label'=>'Pending',   'val'=>$stats['pending'],   'bg'=>'#fef9c3','c'=>'#ca8a04'],
        ['label'=>'Approved',  'val'=>$stats['approved'],  'bg'=>'#dcfce7','c'=>'#16a34a'],
        ['label'=>'Rejected',  'val'=>$stats['rejected'],  'bg'=>'#fee2e2','c'=>'#dc2626'],
        ['label'=>'Completed', 'val'=>$stats['completed'], 'bg'=>'#dbeafe','c'=>'#2563eb'],
    ];
    @endphp
    @foreach($strips as $s)
    <div class="stat-card rounded-2xl border border-slate-200 bg-white p-4 shadow-sm text-center">
        <p class="text-2xl font-extrabold" style="font-family:'Syne',sans-serif;color:{{ $s['c'] }}">{{ $s['val'] }}</p>
        <p class="mt-0.5 text-xs font-semibold text-slate-500">{{ $s['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.enrollments.index') }}"
      class="mb-5 flex flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search student name / email…"
           class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm shadow-sm
                  focus:outline-none focus:border-indigo-400 w-60" />
    <select name="status"
            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                   focus:outline-none focus:border-indigo-400">
        <option value="">All statuses</option>
        @foreach(['pending','approved','rejected','completed','cancelled'] as $st)
        <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
        @endforeach
    </select>
    <select name="payment"
            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                   focus:outline-none focus:border-indigo-400">
        <option value="">All payments</option>
        @foreach(['pending','paid','failed','refunded'] as $p)
        <option value="{{ $p }}" @selected(request('payment')===$p)>{{ ucfirst($p) }}</option>
        @endforeach
    </select>
    <select name="course"
            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                   focus:outline-none focus:border-indigo-400 max-w-[200px]">
        <option value="">All courses</option>
        @foreach($courses as $c)
        <option value="{{ $c->id }}" @selected(request('course')==$c->id)>{{ Str::limit($c->title,35) }}</option>
        @endforeach
    </select>
    <button type="submit" class="rounded-xl px-4 py-2 text-sm font-semibold text-white"
            style="background:var(--brand)">Filter</button>
    @if(request()->hasAny(['search','status','payment','course']))
    <a href="{{ route('admin.enrollments.index') }}" class="text-sm text-slate-400 hover:text-slate-700">Clear</a>
    @endif
</form>

{{-- Table --}}
<div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50/60 text-xs font-bold uppercase
                       tracking-wider text-slate-500">
                <th class="px-6 py-3.5 text-left">Student</th>
                <th class="px-4 py-3.5 text-left hidden md:table-cell">Course</th>
                <th class="px-4 py-3.5 text-center">Status</th>
                <th class="px-4 py-3.5 text-center hidden sm:table-cell">Payment</th>
                <th class="px-4 py-3.5 text-right hidden lg:table-cell">Amount</th>
                <th class="px-4 py-3.5 text-right hidden lg:table-cell">Date</th>
                <th class="px-4 py-3.5 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($enrollments as $enr)
            @php
            $sm=['pending'=>['#fef9c3','#854d0e'],'approved'=>['#dcfce7','#166534'],'rejected'=>['#fee2e2','#991b1b'],'completed'=>['#dbeafe','#1e40af'],'cancelled'=>['#f1f5f9','#64748b']];
            [$sb,$st]=$sm[$enr->status]??['#f1f5f9','#64748b'];
            $pm=['pending'=>['#fef9c3','#854d0e'],'paid'=>['#dcfce7','#166534'],'failed'=>['#fee2e2','#991b1b'],'refunded'=>['#f1f5f9','#64748b']];
            [$pb,$pt]=$pm[$enr->payment_status]??['#f1f5f9','#64748b'];
            @endphp
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full
                                    text-xs font-bold text-white" style="background:var(--brand)">
                            {{ strtoupper(substr($enr->user?->name??'?',0,2)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-slate-900">{{ $enr->user?->name ?? '—' }}</p>
                            <p class="truncate text-xs text-slate-400">{{ $enr->user?->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 hidden md:table-cell">
                    <p class="truncate text-slate-700 max-w-[180px]">{{ $enr->course?->title ?? '—' }}</p>
                </td>
                <td class="px-4 py-4 text-center">
                    <span class="rounded-full px-2.5 py-0.5 text-[11px] font-bold"
                          style="background:{{ $sb }};color:{{ $st }}">
                        {{ ucfirst($enr->status) }}
                    </span>
                </td>
                <td class="px-4 py-4 text-center hidden sm:table-cell">
                    <span class="rounded-full px-2.5 py-0.5 text-[11px] font-bold"
                          style="background:{{ $pb }};color:{{ $pt }}">
                        {{ ucfirst($enr->payment_status) }}
                    </span>
                </td>
                <td class="px-4 py-4 text-right hidden lg:table-cell text-slate-600">
                    {{ $enr->amount_paid ? '₦'.number_format($enr->amount_paid) : '—' }}
                </td>
                <td class="px-4 py-4 text-right hidden lg:table-cell text-slate-400 text-xs">
                    {{ $enr->created_at->format('M d, Y') }}
                </td>
                <td class="px-4 py-4 text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <a href="{{ route('admin.enrollments.show', $enr) }}"
                           class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs font-semibold
                                  text-slate-600 hover:bg-indigo-50 hover:text-indigo-700
                                  hover:border-indigo-200 transition">
                            View
                        </a>
                        @if($enr->status === 'pending')
                        <form method="POST" action="{{ route('admin.enrollments.approve', $enr) }}">
                            @csrf
                            <button type="submit"
                                    class="rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1.5
                                           text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition">
                                Approve
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-14 text-center text-sm text-slate-400">
                    No enrollments found matching your filters.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($enrollments->hasPages())
    <div class="border-t border-slate-100 px-6 py-4">{{ $enrollments->links() }}</div>
    @endif
</div>
@endsection
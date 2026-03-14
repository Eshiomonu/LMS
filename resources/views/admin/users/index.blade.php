@extends('layouts.admin')
@section('title', 'Students')
@section('page-title', 'Students')
@section('page-subtitle', $stats['total'] . ' registered · ' . $stats['pending'] . ' pending approval')

@section('content')

{{-- Stats --}}
<div class="mb-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
    @php
    $strips = [
        ['label'=>'Total',     'val'=>$stats['total'],     'bg'=>'#eef2ff','c'=>'#4f46e5'],
        ['label'=>'Approved',  'val'=>$stats['approved'],  'bg'=>'#dcfce7','c'=>'#16a34a'],
        ['label'=>'Pending',   'val'=>$stats['pending'],   'bg'=>'#fef9c3','c'=>'#ca8a04'],
        ['label'=>'Suspended', 'val'=>$stats['suspended'], 'bg'=>'#fee2e2','c'=>'#dc2626'],
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
<form method="GET" action="{{ route('admin.users.index') }}"
      class="mb-5 flex flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Name or email…"
           class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm shadow-sm
                  focus:outline-none focus:border-indigo-400 w-56" />
    <select name="status"
            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                   focus:outline-none focus:border-indigo-400">
        <option value="">All statuses</option>
        @foreach(['pending','approved','rejected','suspended'] as $st)
        <option value="{{ $st }}" @selected(request('status')===$st)>{{ ucfirst($st) }}</option>
        @endforeach
    </select>
    <button type="submit" class="rounded-xl px-4 py-2 text-sm font-semibold text-white"
            style="background:var(--brand)">Filter</button>
    @if(request()->hasAny(['search','status']))
    <a href="{{ route('admin.users.index') }}" class="text-sm text-slate-400 hover:text-slate-700">Clear</a>
    @endif
</form>

<div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-slate-100 bg-slate-50/60 text-xs font-bold uppercase
                       tracking-wider text-slate-500">
                <th class="px-6 py-3.5 text-left">Student</th>
                <th class="px-4 py-3.5 text-center hidden sm:table-cell">Enrollments</th>
                <th class="px-4 py-3.5 text-center">Status</th>
                <th class="px-4 py-3.5 text-right hidden md:table-cell">Joined</th>
                <th class="px-4 py-3.5 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($users as $user)
            @php
            $sm=['approved'=>['#dcfce7','#166534'],'pending'=>['#fef9c3','#854d0e'],'rejected'=>['#fee2e2','#991b1b'],'suspended'=>['#fef2f2','#dc2626']];
            [$ub,$ut]=$sm[$user->status]??['#f1f5f9','#64748b'];
            @endphp
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full
                                    text-sm font-bold text-white" style="background:var(--brand)">
                            {{ strtoupper(substr($user->name,0,2)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-slate-900">{{ $user->name }}</p>
                            <p class="truncate text-xs text-slate-400">{{ $user->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 text-center hidden sm:table-cell text-slate-600">
                    {{ $user->enrollments_count }}
                </td>
                <td class="px-4 py-4 text-center">
                    <span class="rounded-full px-2.5 py-0.5 text-[11px] font-bold"
                          style="background:{{ $ub }};color:{{ $ut }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </td>
                <td class="px-4 py-4 text-right hidden md:table-cell text-xs text-slate-400">
                    {{ $user->created_at->format('M d, Y') }}
                </td>
                <td class="px-4 py-4 text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs
                                  font-semibold text-slate-600 hover:bg-indigo-50
                                  hover:text-indigo-700 hover:border-indigo-200 transition">
                            View
                        </a>
                        @if($user->status === 'pending')
                        <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                            @csrf
                            <button type="submit"
                                    class="rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1.5
                                           text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition">
                                Approve
                            </button>
                        </form>
                        @elseif($user->status === 'approved')
                        <form method="POST" action="{{ route('admin.users.suspend', $user) }}"
                              onsubmit="return confirm('Suspend this student?')">
                            @csrf
                            <button type="submit"
                                    class="rounded-lg border border-amber-200 bg-amber-50 px-2.5 py-1.5
                                           text-xs font-semibold text-amber-700 hover:bg-amber-100 transition">
                                Suspend
                            </button>
                        </form>
                        @elseif($user->status === 'suspended')
                        <form method="POST" action="{{ route('admin.users.activate', $user) }}">
                            @csrf
                            <button type="submit"
                                    class="rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1.5
                                           text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition">
                                Activate
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-14 text-center text-sm text-slate-400">
                    No students found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($users->hasPages())
    <div class="border-t border-slate-100 px-6 py-4">{{ $users->links() }}</div>
    @endif
</div>
@endsection
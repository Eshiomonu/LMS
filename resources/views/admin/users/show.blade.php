@extends('layouts.admin')
@section('title', $user->name)
@section('page-title', 'Student Profile')
@section('page-subtitle', $user->name . ' — ' . $user->email)

@section('header-actions')
<a href="{{ route('admin.users.edit', $user) }}"
   class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold text-white
          shadow-sm transition hover:opacity-90" style="background:var(--brand)">
    Edit Student
</a>
<a href="{{ route('admin.users.index') }}"
   class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white
          px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition">
    ← Back
</a>
@endsection

@section('content')
<div class="grid grid-cols-1 gap-7 xl:grid-cols-3">

    {{-- LEFT: enrollments list --}}
    <div class="xl:col-span-2 space-y-6">

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-100 px-6 py-4">
                <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                    Enrollments ({{ $user->enrollments->count() }})
                </h3>
            </div>
            @if($user->enrollments->isEmpty())
            <p class="py-12 text-center text-sm text-slate-400">No enrollments yet.</p>
            @else
            <div class="divide-y divide-slate-100">
                @foreach($user->enrollments as $enr)
                @php
                $sm=['pending'=>['#fef9c3','#854d0e'],'approved'=>['#dcfce7','#166534'],'rejected'=>['#fee2e2','#991b1b'],'completed'=>['#dbeafe','#1e40af'],'cancelled'=>['#f1f5f9','#64748b']];
                [$sb,$st]=$sm[$enr->status]??['#f1f5f9','#64748b'];
                $pm=['pending'=>['#fef9c3','#854d0e'],'paid'=>['#dcfce7','#166534'],'failed'=>['#fee2e2','#991b1b'],'refunded'=>['#f1f5f9','#64748b']];
                [$pb,$pt]=$pm[$enr->payment_status]??['#f1f5f9','#64748b'];
                @endphp
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition">
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-slate-900 truncate">
                            {{ $enr->course?->title ?? '—' }}
                        </p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $enr->created_at->format('M d, Y') }}
                            @if($enr->amount_paid) · ₦{{ number_format($enr->amount_paid) }} @endif
                        </p>
                    </div>
                    <div class="flex flex-shrink-0 gap-2">
                        <span class="rounded-full px-2.5 py-0.5 text-[11px] font-bold"
                              style="background:{{ $sb }};color:{{ $st }}">
                            {{ ucfirst($enr->status) }}
                        </span>
                        <span class="rounded-full px-2.5 py-0.5 text-[11px] font-bold"
                              style="background:{{ $pb }};color:{{ $pt }}">
                            {{ ucfirst($enr->payment_status) }}
                        </span>
                    </div>
                    <a href="{{ route('admin.enrollments.show', $enr) }}"
                       class="flex-shrink-0 text-xs font-semibold hover:underline"
                       style="color:var(--brand)">View →</a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- RIGHT: profile + actions --}}
    <div class="space-y-6">

        {{-- Profile card --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full
                        text-2xl font-extrabold text-white" style="background:var(--brand)">
                {{ strtoupper(substr($user->name,0,2)) }}
            </div>
            <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                {{ $user->name }}
            </h3>
            <p class="text-sm text-slate-400 mt-0.5">{{ $user->email }}</p>
            @if($user->phone)
            <p class="text-sm text-slate-400 mt-0.5">{{ $user->phone }}</p>
            @endif
            @php
            $sm=['approved'=>['#dcfce7','#166534'],'pending'=>['#fef9c3','#854d0e'],'rejected'=>['#fee2e2','#991b1b'],'suspended'=>['#fef2f2','#dc2626']];
            [$ub,$ut]=$sm[$user->status]??['#f1f5f9','#64748b'];
            @endphp
            <span class="mt-3 inline-block rounded-full px-3 py-1 text-xs font-bold"
                  style="background:{{ $ub }};color:{{ $ut }}">
                {{ ucfirst($user->status) }}
            </span>
        </div>

        {{-- Stats --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">Stats</h3>
            <dl class="space-y-3 text-sm">
                @foreach([
                    ['Total Enrollments', $user->enrollments->count()],
                    ['Approved', $user->enrollments->where('status','approved')->count()],
                    ['Pending', $user->enrollments->where('status','pending')->count()],
                    ['Total Paid', '₦'.number_format($user->enrollments->where('payment_status','paid')->sum('amount_paid'))],
                    ['Joined', $user->created_at->format('M d, Y')],
                    ['Last Active', $user->updated_at->diffForHumans()],
                ] as [$lbl,$val])
                <div class="flex justify-between">
                    <dt class="text-slate-500">{{ $lbl }}</dt>
                    <dd class="font-semibold text-slate-900">{{ $val }}</dd>
                </div>
                @endforeach
            </dl>
        </div>

        {{-- Actions --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-2">
            <h3 class="mb-3 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">Actions</h3>

            @if($user->status === 'pending')
            <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                @csrf
                <button class="w-full rounded-xl bg-emerald-600 py-2.5 text-sm font-bold text-white
                               hover:bg-emerald-700 transition">✓ Approve Student</button>
            </form>
            @endif

            @if($user->status === 'approved')
            <form method="POST" action="{{ route('admin.users.suspend', $user) }}"
                  onsubmit="return confirm('Suspend this student?')">
                @csrf
                <button class="w-full rounded-xl border border-amber-300 bg-amber-50 py-2.5 text-sm
                               font-bold text-amber-700 hover:bg-amber-100 transition">
                    Suspend Account
                </button>
            </form>
            @endif

            @if($user->status === 'suspended')
            <form method="POST" action="{{ route('admin.users.activate', $user) }}">
                @csrf
                <button class="w-full rounded-xl bg-emerald-600 py-2.5 text-sm font-bold text-white
                               hover:bg-emerald-700 transition">Reactivate Account</button>
            </form>
            @endif

            <a href="{{ route('admin.users.edit', $user) }}"
               class="block w-full rounded-xl border border-slate-200 py-2.5 text-center text-sm
                      font-semibold text-slate-600 hover:bg-slate-50 transition">
                Edit Details
            </a>

            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirm('Permanently delete this student?')">
                @csrf @method('DELETE')
                <button class="w-full rounded-xl border border-red-200 bg-red-50 py-2.5 text-sm
                               font-bold text-red-700 hover:bg-red-100 transition">
                    Delete Student
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
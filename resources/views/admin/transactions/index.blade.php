@extends('layouts.admin')
@section('title', 'Transactions')
@section('page-title', 'Transactions & Payments')
@section('page-subtitle', 'All payment records across enrollments')

@section('content')

{{-- Revenue summary --}}
<div class="mb-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
    @php
    $strips = [
        ['label'=>'Total Collected', 'val'=>'₦'.number_format($stats['total_paid'],2), 'bg'=>'#dcfce7','c'=>'#16a34a'],
        ['label'=>'Paid',     'val'=>$stats['count_paid'],     'bg'=>'#dcfce7','c'=>'#16a34a'],
        ['label'=>'Pending',  'val'=>$stats['count_pending'],  'bg'=>'#fef9c3','c'=>'#ca8a04'],
        ['label'=>'Failed',   'val'=>$stats['count_failed'],   'bg'=>'#fee2e2','c'=>'#dc2626'],
        ['label'=>'Refunded', 'val'=>$stats['count_refunded'], 'bg'=>'#f1f5f9','c'=>'#64748b'],
    ];
    @endphp
    @foreach($strips as $s)
    <div class="stat-card rounded-2xl border border-slate-200 bg-white p-4 shadow-sm text-center">
        <p class="text-xl font-extrabold" style="font-family:'Syne',sans-serif;color:{{ $s['c'] }}">
            {{ $s['val'] }}
        </p>
        <p class="mt-0.5 text-xs font-semibold text-slate-500">{{ $s['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Filters --}}
<form method="GET" action="{{ route('admin.transactions.index') }}"
      class="mb-5 flex flex-wrap items-center gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Student name or transaction ref…"
           class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm shadow-sm
                  focus:outline-none focus:border-indigo-400 w-64" />
    <select name="payment_status"
            class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm shadow-sm
                   focus:outline-none focus:border-indigo-400">
        <option value="">All payments</option>
        @foreach(['pending','paid','failed','refunded'] as $p)
        <option value="{{ $p }}" @selected(request('payment_status')===$p)>{{ ucfirst($p) }}</option>
        @endforeach
    </select>
    <button type="submit" class="rounded-xl px-4 py-2 text-sm font-semibold text-white"
            style="background:var(--brand)">Filter</button>
    @if(request()->hasAny(['search','payment_status']))
    <a href="{{ route('admin.transactions.index') }}"
       class="text-sm text-slate-400 hover:text-slate-700">Clear</a>
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
                <th class="px-4 py-3.5 text-right">Amount</th>
                <th class="px-4 py-3.5 text-center">Payment</th>
                <th class="px-4 py-3.5 text-left hidden lg:table-cell">Ref</th>
                <th class="px-4 py-3.5 text-right hidden lg:table-cell">Date</th>
                <th class="px-4 py-3.5 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($transactions as $txn)
            @php
            $pm=['pending'=>['#fef9c3','#854d0e'],'paid'=>['#dcfce7','#166534'],'failed'=>['#fee2e2','#991b1b'],'refunded'=>['#f1f5f9','#64748b']];
            [$pb,$pt]=$pm[$txn->payment_status]??['#f1f5f9','#64748b'];
            @endphp
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full
                                    text-xs font-bold text-white" style="background:var(--brand)">
                            {{ strtoupper(substr($txn->user?->name??'?',0,2)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate font-semibold text-slate-900">{{ $txn->user?->name ?? '—' }}</p>
                            <p class="truncate text-xs text-slate-400">{{ $txn->user?->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 py-4 hidden md:table-cell">
                    <p class="truncate text-slate-700 max-w-[160px] text-xs">{{ $txn->course?->title ?? '—' }}</p>
                </td>
                <td class="px-4 py-4 text-right font-semibold text-slate-800">
                    {{ $txn->amount_paid ? $txn->currency.' '.number_format($txn->amount_paid, 2) : '—' }}
                </td>
                <td class="px-4 py-4 text-center">
                    <span class="rounded-full px-2.5 py-0.5 text-[11px] font-bold"
                          style="background:{{ $pb }};color:{{ $pt }}">
                        {{ ucfirst($txn->payment_status) }}
                    </span>
                </td>
                <td class="px-4 py-4 hidden lg:table-cell text-xs text-slate-400 font-mono">
                    {{ $txn->transaction_ref ?: '—' }}
                </td>
                <td class="px-4 py-4 text-right hidden lg:table-cell text-xs text-slate-400">
                    {{ $txn->created_at->format('M d, Y') }}
                </td>
                <td class="px-4 py-4 text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <a href="{{ route('admin.transactions.show', $txn) }}"
                           class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs font-semibold
                                  text-slate-600 hover:bg-indigo-50 hover:text-indigo-700
                                  hover:border-indigo-200 transition">
                            View
                        </a>
                        @if($txn->payment_status !== 'paid')
                        <form method="POST" action="{{ route('admin.transactions.mark-paid', $txn) }}"
                              x-data x-on:submit.prevent="
                                const amt = prompt('Enter amount paid ({{ $txn->course?->currency ?? 'NGN' }}):');
                                if(amt) { $el.querySelector('[name=amount_paid]').value = amt; $el.submit(); }
                              ">
                            @csrf
                            <input type="hidden" name="amount_paid" value="{{ $txn->course?->price ?? 0 }}" />
                            <button type="submit"
                                    class="rounded-lg border border-emerald-200 bg-emerald-50 px-2.5 py-1.5
                                           text-xs font-semibold text-emerald-700 hover:bg-emerald-100 transition">
                                Mark Paid
                            </button>
                        </form>
                        @endif
                        @if($txn->payment_status === 'paid')
                        <form method="POST" action="{{ route('admin.transactions.mark-refunded', $txn) }}"
                              onsubmit="return confirm('Mark as refunded?')">
                            @csrf
                            <button type="submit"
                                    class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs
                                           font-semibold text-slate-600 hover:bg-slate-50 transition">
                                Refund
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-14 text-center text-sm text-slate-400">
                    No transactions found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($transactions->hasPages())
    <div class="border-t border-slate-100 px-6 py-4">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
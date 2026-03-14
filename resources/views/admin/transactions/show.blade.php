@extends('layouts.admin')
@section('title', 'Transaction — #' . $enrollment->id)
@section('page-title', 'Transaction Detail')
@section('page-subtitle', 'Enrollment #' . $enrollment->id . ' — ' . ($enrollment->user?->name ?? '?'))

@section('header-actions')
<a href="{{ route('admin.transactions.index') }}"
   class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white
          px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition">
    ← Back to Transactions
</a>
@endsection

@push('styles')
<style>
    .form-label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:5px; }
    .form-input { width:100%; border-radius:10px; border:1px solid #e2e8f0; padding:9px 12px; font-size:13.5px; color:#0f172a; outline:none; transition:border-color .15s; }
    .form-input:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.1); }
</style>
@endpush

@section('content')
@php
$pm=['pending'=>['#fef9c3','#854d0e'],'paid'=>['#dcfce7','#166534'],'failed'=>['#fee2e2','#991b1b'],'refunded'=>['#f1f5f9','#64748b']];
[$pb,$pt]=$pm[$enrollment->payment_status]??['#f1f5f9','#64748b'];
@endphp

<div class="grid grid-cols-1 gap-7 xl:grid-cols-3">

    {{-- Main --}}
    <div class="xl:col-span-2 space-y-6">

        {{-- Payment details --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6 flex items-center justify-between">
                <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                    Payment Record
                </h3>
                <span class="rounded-full px-3 py-1 text-sm font-bold"
                      style="background:{{ $pb }};color:{{ $pt }}">
                    {{ ucfirst($enrollment->payment_status) }}
                </span>
            </div>

            <dl class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                @foreach([
                    ['Enrollment ID',   '#'.$enrollment->id],
                    ['Amount',          $enrollment->amount_paid ? $enrollment->currency.' '.number_format($enrollment->amount_paid,2) : '—'],
                    ['Currency',        $enrollment->currency ?? '—'],
                    ['Transaction Ref', $enrollment->transaction_ref ?? '—'],
                    ['Payment Status',  ucfirst($enrollment->payment_status)],
                    ['Enrollment Status', ucfirst($enrollment->status)],
                    ['Date',            $enrollment->created_at->format('M d, Y H:i')],
                    ['Updated',         $enrollment->updated_at->format('M d, Y H:i')],
                    ['Course Price',    $enrollment->course ? '₦'.number_format($enrollment->course->price) : '—'],
                ] as [$lbl,$val])
                <div class="rounded-xl bg-slate-50 p-3">
                    <dt class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">{{ $lbl }}</dt>
                    <dd class="mt-1 text-sm font-semibold text-slate-900 break-all">{{ $val }}</dd>
                </div>
                @endforeach
            </dl>
        </div>

        {{-- Manual payment entry --}}
        @if($enrollment->payment_status !== 'paid')
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Record Manual Payment
            </h3>
            <form method="POST" action="{{ route('admin.transactions.mark-paid', $enrollment) }}"
                  class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                @csrf
                <div>
                    <label class="form-label">Amount Paid</label>
                    <input type="number" name="amount_paid" step="0.01" min="0"
                           value="{{ $enrollment->course?->price ?? '' }}"
                           required class="form-input" />
                </div>
                <div>
                    <label class="form-label">Currency</label>
                    <select name="currency" class="form-input" style="appearance:auto">
                        @foreach(['NGN','USD','GBP'] as $c)
                        <option value="{{ $c }}" @selected(($enrollment->currency??'NGN')===$c)>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Transaction Ref</label>
                    <input type="text" name="transaction_ref"
                           value="{{ $enrollment->transaction_ref }}"
                           placeholder="Optional reference"
                           class="form-input" />
                </div>
                <div class="sm:col-span-3">
                    <button type="submit"
                            class="rounded-xl px-6 py-2.5 text-sm font-bold text-white
                                   transition hover:opacity-90" style="background:var(--brand)">
                        Mark as Paid
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">

        {{-- Student --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">Student</h3>
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-full text-base font-bold text-white"
                     style="background:var(--brand)">
                    {{ strtoupper(substr($enrollment->user?->name??'?',0,2)) }}
                </div>
                <div>
                    <p class="font-bold text-slate-900">{{ $enrollment->user?->name ?? '—' }}</p>
                    <p class="text-xs text-slate-400">{{ $enrollment->user?->email }}</p>
                    @if($enrollment->user?->phone)
                    <p class="text-xs text-slate-400">{{ $enrollment->user->phone }}</p>
                    @endif
                </div>
            </div>
            @if($enrollment->user)
            <a href="{{ route('admin.users.show', $enrollment->user) }}"
               class="block w-full rounded-xl border border-slate-200 py-2 text-center text-sm
                      font-semibold text-slate-600 hover:bg-slate-50 transition">
                View Profile →
            </a>
            @endif
        </div>

        {{-- Course --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-3 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">Course</h3>
            <p class="text-sm font-semibold text-slate-800 mb-1">{{ $enrollment->course?->title ?? '—' }}</p>
            <p class="text-xs text-slate-500 mb-1">{{ $enrollment->course?->category?->name ?? 'Uncategorised' }}</p>
            <p class="text-sm font-bold" style="color:var(--brand)">
                ₦{{ number_format($enrollment->course?->price ?? 0) }}
            </p>
        </div>

        {{-- Actions --}}
        @if($enrollment->payment_status === 'paid')
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="mb-3 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">Actions</h3>
            <form method="POST" action="{{ route('admin.transactions.mark-refunded', $enrollment) }}"
                  onsubmit="return confirm('Mark this payment as refunded?')">
                @csrf
                <button class="w-full rounded-xl border border-slate-200 py-2.5 text-sm font-semibold
                               text-slate-600 hover:bg-slate-50 transition">
                    Issue Refund
                </button>
            </form>
        </div>
        @endif

        {{-- Enrollment link --}}
        <a href="{{ route('admin.enrollments.show', $enrollment) }}"
           class="block rounded-2xl border border-indigo-100 bg-indigo-50 p-4 text-center
                  text-sm font-semibold text-indigo-700 hover:bg-indigo-100 transition">
            View Full Enrollment Record →
        </a>
    </div>
</div>
@endsection
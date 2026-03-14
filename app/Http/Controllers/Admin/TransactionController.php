<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['user', 'course'])
            ->whereNotNull('amount_paid')
            ->orWhere('payment_status', '!=', 'pending')
            ->latest();

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('transaction_ref', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%'.$request->search.'%'));
            });
        }

        $transactions = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total_paid'     => Enrollment::where('payment_status', 'paid')->sum('amount_paid'),
            'total_refunded' => Enrollment::where('payment_status', 'refunded')->sum('amount_paid'),
            'count_paid'     => Enrollment::where('payment_status', 'paid')->count(),
            'count_pending'  => Enrollment::where('payment_status', 'pending')->count(),
            'count_failed'   => Enrollment::where('payment_status', 'failed')->count(),
            'count_refunded' => Enrollment::where('payment_status', 'refunded')->count(),
        ];

        return view('admin.transactions.index', compact('transactions', 'stats'));
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['user', 'course']);
        return view('admin.transactions.show', compact('enrollment'));
    }

    public function markPaid(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'transaction_ref' => ['nullable', 'string', 'max:255'],
            'amount_paid'     => ['required', 'numeric', 'min:0'],
        ]);
        $enrollment->update([
            'payment_status'  => 'paid',
            'amount_paid'     => $request->amount_paid,
            'transaction_ref' => $request->transaction_ref ?? $enrollment->transaction_ref,
            'currency'        => $request->currency ?? 'NGN',
        ]);
        return back()->with('success', 'Payment marked as paid.');
    }

    public function markRefunded(Enrollment $enrollment)
    {
        $enrollment->update(['payment_status' => 'refunded']);
        return back()->with('success', 'Payment marked as refunded.');
    }
}
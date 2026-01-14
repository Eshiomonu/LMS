@extends('layouts.app')

@section('title', 'Checkout - ' . $course->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Course Summary --}}
    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-xl font-semibold mb-2">{{ $course->title }}</h2>
        <p class="text-gray-700 mb-2">{{ $course->short_description }}</p>
        <p class="font-semibold">Fee: ₦{{ number_format($course->course_fee) }}</p>
        <p>Duration: {{ $course->duration_hours }} hours ({{ $course->duration_weeks }} weeks)</p>
    </div>

    {{-- User Info --}}
    <div class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-2">Your Information</h2>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    {{-- Payment / Enrollment Form --}}
    <form action="{{ route('checkout.process', $course->id) }}" method="POST" class="bg-white rounded shadow p-6 space-y-6">
        @csrf

        <div>
            <label class="label">Payment Method</label>
            <select name="payment_method" class="input w-full" required>
                <option value="">Select a payment method</option>
                <option value="card" @selected(old('payment_method')=='card')>Card Payment</option>
                <option value="bank_transfer" @selected(old('payment_method')=='bank_transfer')>Bank Transfer</option>
            </select>
            @error('payment_method') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="agree_terms" value="1" class="rounded" required>
                <span>I agree to the <a href="#" class="text-blue-600 underline">terms and conditions</a></span>
            </label>
            @error('agree_terms') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
                class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
            Complete Enrollment
        </button>
    </form>
</div>
@endsection

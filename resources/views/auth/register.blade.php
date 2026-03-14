@extends('layouts.app')
@section('title', 'Register | AsproHubs')

@section('content')
<div class="flex flex-col sm:justify-center items-center py-20 bg-gray-50 px-4">
    <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100 relative">

        {{-- Top accent bar --}}
        <div class="absolute top-0 left-0 w-full h-1.5 bg-[var(--aspro-primary)]"></div>

        <div class="mb-8 text-center">
            <a href="{{ route('home') }}" class="inline-block mb-4">
                <span class="text-xl font-extrabold text-[var(--aspro-primary)]" style="font-family:'Syne',sans-serif;">
                    AsproHubs
                </span>
            </a>
            <h2 class="text-2xl font-bold text-[var(--aspro-primary)]">Create Account</h2>
            <p class="text-gray-500 text-sm mt-1">Join AsproHubs to start learning today</p>

            {{-- Enrolling for a course notice --}}
            @if(request('redirect'))
            <div class="mt-3 rounded-xl bg-[var(--aspro-primary-light)] px-4 py-2 text-sm text-[var(--aspro-primary)] font-medium">
                Create your account to complete enrollment
            </div>
            @endif
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- Pass redirect URL through so controller can use after register --}}
            @if(request('redirect'))
            <input type="hidden" name="redirect_to" value="{{ request('redirect') }}">
            @endif

            {{-- Full Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required autofocus autocomplete="name"
                    class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900
                           focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]
                           @error('name') border-red-400 bg-red-50 @enderror"
                />
                @error('name')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required autocomplete="username"
                    class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900
                           focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]
                           @error('email') border-red-400 bg-red-50 @enderror"
                />
                @error('email')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone (optional but helpful for enrollment) --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                    Phone Number <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <input
                    id="phone"
                    type="tel"
                    name="phone"
                    value="{{ old('phone') }}"
                    autocomplete="tel"
                    placeholder="+234 800 000 0000"
                    class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900
                           focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]"
                />
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required autocomplete="new-password"
                    class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900
                           focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]
                           @error('password') border-red-400 bg-red-50 @enderror"
                />
                @error('password')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Confirm Password
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required autocomplete="new-password"
                    class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900
                           focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]"
                />
            </div>

            {{-- Submit --}}
            <div class="pt-1">
                <button type="submit"
                        class="w-full rounded-xl py-3 font-bold text-white text-sm transition shadow-md
                               bg-[var(--aspro-primary)] hover:bg-[var(--aspro-primary-dark)] active:scale-[0.98]">
                    Create Account
                </button>
            </div>

            {{-- Login link --}}
            <div class="text-center pt-2">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}{{ request('redirect') ? '?redirect='.request('redirect') : '' }}"
                       class="font-bold text-[var(--aspro-primary)] hover:underline">
                        Sign in here
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
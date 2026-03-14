@extends('layouts.app')
@section('title', 'Login | AsproHubs')

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
            <h2 class="text-2xl font-bold text-[var(--aspro-primary)]">Welcome Back</h2>
            <p class="text-gray-500 text-sm mt-1">Sign in to continue your learning journey</p>

            {{-- Show which course they're trying to enroll in --}}
            @if(request('redirect') || session('intended_course'))
            <div class="mt-3 rounded-xl bg-[var(--aspro-primary-light)] px-4 py-2 text-sm text-[var(--aspro-primary)] font-medium">
                Sign in to complete your enrollment
            </div>
            @endif
        </div>

        {{-- Session status --}}
        @if(session('status'))
        <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
            {{ session('status') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Pass redirect URL through form so controller can use it --}}
            @if(request('redirect'))
            <input type="hidden" name="redirect_to" value="{{ request('redirect') }}">
            @endif

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required autofocus autocomplete="username"
                    class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900
                           focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]
                           @error('email') border-red-400 bg-red-50 @enderror"
                />
                @error('email')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required autocomplete="current-password"
                    class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm text-gray-900
                           focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]
                           @error('password') border-red-400 bg-red-50 @enderror"
                />
                @error('password')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember + Forgot --}}
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="rounded border-gray-300 text-[var(--aspro-primary)] focus:ring-[var(--aspro-primary)]" />
                    <span class="text-sm text-gray-600">Remember me</span>
                </label>
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm font-semibold text-[var(--aspro-primary)] hover:underline">
                    Forgot password?
                </a>
                @endif
            </div>

            {{-- Submit --}}
            <div class="pt-1">
                <button type="submit"
                        class="w-full rounded-xl py-3 font-bold text-white text-sm transition shadow-md
                               bg-[var(--aspro-primary)] hover:bg-[var(--aspro-primary-dark)] active:scale-[0.98]">
                    Log in
                </button>
            </div>

            {{-- Register link --}}
            <div class="text-center pt-2">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}{{ request('redirect') ? '?redirect='.request('redirect') : '' }}"
                       class="font-bold text-[var(--aspro-primary)] hover:underline">
                        Register here
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
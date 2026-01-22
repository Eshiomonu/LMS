@extends('layouts.app')

@section('title', 'Login | AsproHubs')

@section('content')
<div class="flex flex-col sm:justify-center items-center py-20 bg-gray-50 px-4">
    <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100 relative">
        {{-- Subtle Top Accent Bar --}}
        <div class="absolute top-0 left-0 w-full h-1.5 bg-(--aspro-primary)"></div>

        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold text-(--aspro-primary)">Welcome Back</h2>
            <p class="text-gray-500 text-sm mt-1">Sign in to continue your learning journey</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
                <x-text-input id="email" class="block mt-1 w-full text-gray-900 border-gray-300 focus:border-(--aspro-primary) focus:ring-(--aspro-primary)" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                <x-text-input id="password" class="block mt-1 w-full text-gray-900 border-gray-300 focus:border-(--aspro-primary) focus:ring-(--aspro-primary)"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-(--aspro-primary) shadow-sm focus:ring-(--aspro-primary)" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-(--aspro-primary) hover:underline font-semibold" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-(--aspro-primary) text-white font-bold py-3 px-4 rounded-xl hover:opacity-90 transition-all shadow-md active:scale-[0.98]">
                    {{ __('Log in') }}
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-(--aspro-primary) font-bold hover:underline">
                        Register here
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

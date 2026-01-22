@extends('layouts.app')

@section('title', 'Register | AsproHubs')

@section('content')
<div class="flex flex-col sm:justify-center items-center py-20 bg-gray-50 px-4">
    <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100 relative">
        {{-- Subtle Top Accent Bar --}}
        <div class="absolute top-0 left-0 w-full h-1.5 bg-(--aspro-primary)"></div>

        <div class="mb-8 text-center">
            <h2 class="text-2xl font-bold text-(--aspro-primary)">Create Account</h2>
            <p class="text-gray-500 text-sm mt-1">Join AsproHubs to start learning today</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" class="text-gray-700 font-medium" />
                <x-text-input id="name" class="block mt-1 w-full text-gray-900 border-gray-300 focus:border-(--aspro-primary) focus:ring-(--aspro-primary)" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-medium" />
                <x-text-input id="email" class="block mt-1 w-full text-gray-900 border-gray-300 focus:border-(--aspro-primary) focus:ring-(--aspro-primary)" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />
                <x-text-input id="password" class="block mt-1 w-full text-gray-900 border-gray-300 focus:border-(--aspro-primary) focus:ring-(--aspro-primary)"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full text-gray-900 border-gray-300 focus:border-(--aspro-primary) focus:ring-(--aspro-primary)"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-(--aspro-primary) text-white font-bold py-3 px-4 rounded-xl hover:opacity-90 transition-all shadow-md active:scale-[0.98]">
                    {{ __('Register') }}
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-(--aspro-primary) font-bold hover:underline">
                        Sign in here
                    </a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.student')
@section('title', 'Profile Settings')
@section('page-title', 'Profile Settings')

@section('content')

<div class="max-w-2xl space-y-6">

    {{-- ── Personal Information ── --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="mb-1 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
            Personal Information
        </h3>
        <p class="mb-6 text-sm text-slate-400">Update your name, email, phone and bio</p>

        <form method="POST" action="{{ route('student.profile.update') }}"
              enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Avatar --}}
            <div class="flex items-center gap-5">
                <div class="relative flex-shrink-0">
                    <img id="avatar-preview"
                         src="{{ auth()->user()->avatar_url }}"
                         alt="{{ auth()->user()->name }}"
                         class="h-20 w-20 rounded-2xl object-cover border-2 border-slate-200 shadow-sm"/>
                    <label for="avatar"
                           class="absolute -bottom-1 -right-1 flex h-7 w-7 cursor-pointer
                                  items-center justify-center rounded-full text-white shadow
                                  hover:opacity-90 transition"
                           style="background:var(--aspro-primary)">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </label>
                    <input id="avatar" type="file" name="avatar" class="hidden"
                           accept="image/*" onchange="previewAvatar(event)"/>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-700">Profile Photo</p>
                    <p class="text-xs text-slate-400 mt-0.5">JPG, PNG or GIF — max 2MB</p>
                </div>
            </div>

            {{-- Name --}}
            <div>
                <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input id="name" type="text" name="name"
                       value="{{ old('name', auth()->user()->name) }}" required
                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900
                              focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]
                              @error('name') border-red-400 bg-red-50 @enderror"/>
                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input id="email" type="email" name="email"
                       value="{{ old('email', auth()->user()->email) }}" required
                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900
                              focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]
                              @error('email') border-red-400 bg-red-50 @enderror"/>
                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Phone Number
                </label>
                <input id="phone" type="tel" name="phone"
                       value="{{ old('phone', auth()->user()->phone) }}"
                       placeholder="+234 800 000 0000"
                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900
                              focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]"/>
            </div>

            {{-- Bio --}}
            <div>
                <label for="bio" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Bio <span class="text-slate-400 font-normal">(optional)</span>
                </label>
                <textarea id="bio" name="bio" rows="3"
                          placeholder="Tell us a little about yourself…"
                          class="w-full resize-none rounded-xl border border-slate-300 px-4 py-2.5
                                 text-sm text-slate-900 focus:outline-none
                                 focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]"
                >{{ old('bio', auth()->user()->bio) }}</textarea>
            </div>

            <div class="pt-1">
                <button type="submit"
                        class="rounded-xl px-6 py-2.5 text-sm font-bold text-white shadow-sm transition"
                        style="background:var(--aspro-primary)">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    {{-- ── Change Password ── --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="mb-1 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
            Change Password
        </h3>
        <p class="mb-6 text-sm text-slate-400">Leave blank to keep your current password</p>

        <form method="POST" action="{{ route('student.profile.password') }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Current Password <span class="text-red-500">*</span>
                </label>
                <input id="current_password" type="password" name="current_password"
                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900
                              focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]
                              @error('current_password') border-red-400 bg-red-50 @enderror"/>
                @error('current_password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="new_password" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    New Password <span class="text-red-500">*</span>
                </label>
                <input id="new_password" type="password" name="password"
                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900
                              focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]
                              @error('password') border-red-400 bg-red-50 @enderror"/>
                @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Confirm New Password <span class="text-red-500">*</span>
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900
                              focus:outline-none focus:border-[var(--aspro-primary)] focus:ring-1 focus:ring-[var(--aspro-primary)]"/>
            </div>

            <div class="pt-1">
                <button type="submit"
                        class="rounded-xl px-6 py-2.5 text-sm font-bold text-white shadow-sm transition"
                        style="background:var(--aspro-primary)">
                    Update Password
                </button>
            </div>
        </form>
    </div>

    {{-- ── Account Info ── --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="mb-4 font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
            Account Info
        </h3>
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between">
                <dt class="text-slate-500">Account Type</dt>
                <dd class="font-semibold capitalize text-slate-900">{{ auth()->user()->role }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-slate-500">Status</dt>
                <dd>
                    <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-700">
                        {{ ucfirst(auth()->user()->status) }}
                    </span>
                </dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-slate-500">Member since</dt>
                <dd class="font-medium text-slate-900">{{ auth()->user()->created_at->format('F d, Y') }}</dd>
            </div>
            <div class="flex justify-between">
                <dt class="text-slate-500">Email</dt>
                <dd class="font-medium text-slate-900">{{ auth()->user()->email }}</dd>
            </div>
        </dl>
    </div>

</div>

@push('scripts')
<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => document.getElementById('avatar-preview').src = e.target.result;
    reader.readAsDataURL(file);
}
</script>
@endpush

@endsection
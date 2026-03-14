@extends('layouts.admin')
@section('title', 'Edit — ' . $user->name)
@section('page-title', 'Edit Student')
@section('page-subtitle', $user->name)

@section('header-actions')
<a href="{{ route('admin.users.show', $user) }}"
   class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white
          px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition">
    ← Back to Profile
</a>
@endsection

@push('styles')
<style>
    .form-label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:5px; }
    .form-input { width:100%; border-radius:10px; border:1px solid #e2e8f0; padding:9px 12px; font-size:13.5px; color:#0f172a; outline:none; transition:border-color .15s; }
    .form-input:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.1); }
    .form-error { color:#dc2626; font-size:12px; margin-top:4px; }
</style>
@endpush

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-5">
            <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                Student Details
            </h3>

            <div>
                <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       required class="form-input {{ $errors->has('name') ? 'border-red-400' : '' }}" />
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       required class="form-input {{ $errors->has('email') ? 'border-red-400' : '' }}" />
                @error('email') <p class="form-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                       class="form-input" />
            </div>

            <div>
                <label class="form-label">Account Status <span class="text-red-500">*</span></label>
                <select name="status" required class="form-input" style="appearance:auto">
                    @foreach(['pending'=>'Pending Approval','approved'=>'Approved','rejected'=>'Rejected','suspended'=>'Suspended'] as $val => $lbl)
                    <option value="{{ $val }}" @selected(old('status', $user->status)===$val)>{{ $lbl }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 rounded-xl py-2.5 text-sm font-bold text-white
                               transition hover:opacity-90" style="background:var(--brand)">
                    Save Changes
                </button>
                <a href="{{ route('admin.users.show', $user) }}"
                   class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold
                          text-slate-600 hover:bg-slate-50 transition">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
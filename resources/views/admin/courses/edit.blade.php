@extends('layouts.admin')
@section('title', 'Edit: ' . $course->title)
@section('page-title', 'Edit Course')
@section('page-subtitle', $course->title)

@section('header-actions')
<a href="{{ route('admin.courses.show', $course) }}"
   class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white
          px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition">
    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
    </svg>
    Preview
</a>
@endsection

@push('styles')
<style>
    .form-label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:5px; }
    .form-input {
        width:100%; border-radius:10px; border:1px solid #e2e8f0; padding:9px 12px;
        font-size:13.5px; color:#0f172a; background:#fff;
        outline:none; transition:border-color .15s;
    }
    .form-input:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.1); }
    select.form-input { appearance:auto; }
    textarea.form-input { resize:vertical; }
    .form-error { color:#dc2626; font-size:12px; margin-top:4px; }
</style>
@endpush

@section('content')
<form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.courses._form', ['submitLabel' => 'Save Changes'])
</form>
@endsection
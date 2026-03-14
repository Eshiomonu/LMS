@extends('layouts.admin')
@section('title', 'New Course')
@section('page-title', 'New Course')
@section('page-subtitle', 'Fill in the details below to create a new course')

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
<form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.courses._form', ['submitLabel' => 'Create Course'])
</form>
@endsection
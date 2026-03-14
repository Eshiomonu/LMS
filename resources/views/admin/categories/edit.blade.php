@extends('layouts.admin')
@section('title', 'Edit — ' . $category->name)
@section('page-title', 'Edit Category')
@section('page-subtitle', $category->name)

@section('header-actions')
<a href="{{ route('admin.categories.index') }}"
   class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white
          px-4 py-2 text-sm font-semibold text-slate-600 shadow-sm hover:bg-slate-50 transition">
    ← Back
</a>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.categories.update', $category) }}">
    @csrf @method('PUT')
    @include('admin.categories._form', ['submitLabel' => 'Save Changes'])
</form>
@endsection
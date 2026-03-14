@extends('layouts.admin')
@section('title', 'New Category')
@section('page-title', 'New Category')
@section('page-subtitle', 'Add a new course category')

@section('content')
<form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    @include('admin.categories._form', ['submitLabel' => 'Create Category'])
</form>
@endsection
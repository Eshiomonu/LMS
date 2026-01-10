@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('header-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-2">Total Students</h2>
            <p class="text-2xl">150</p>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-2">Total Courses</h2>
            <p class="text-2xl">25</p>
        </div>
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-2">Pending Approvals</h2>
            <p class="text-2xl">5</p>
        </div>
    </div>
@endsection

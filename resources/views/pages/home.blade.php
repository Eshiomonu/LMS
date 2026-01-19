@extends('layouts.app')

@section('title', 'Professional Courses & Training | AsproHubs')
@section('meta_description', 'Learn industry-ready skills with expert-led professional courses on AsproHubs.')

@section('content')
    <x-home.hero />
    <x-home.trust-metrics />

    <x-home.featured-courses :courses="$courses" />
@endsection

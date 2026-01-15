@extends('layouts.app')

@section('content')

<section class="bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <h1 class="display-5 fw-bold">{{ $course->title }}</h1>
                <p class="lead">{{ $course->excerpt }}</p>

                <div class="d-flex gap-3 mt-3 flex-wrap">
                    <span><i class="bi bi-clock"></i> {{ $course->duration }}</span>
                    <span><i class="bi bi-play-circle"></i> {{ ucfirst($course->type) }}</span>
                    <span><i class="bi bi-currency-dollar"></i> {{ number_format($course->price, 2) }}</span>
                </div>

                <button class="btn btn-light btn-lg mt-4 hover-scale" 
                        data-bs-toggle="modal" 
                        data-bs-target="#checkoutModal">
                    Enroll Now
                </button>
            </div>

            <div class="col-lg-6">
                <img src="{{ $course->hero_image ? asset('uploads/hero/' . $course->hero_image) : asset('assets/images/hero-default.jpg') }}"
                     class="img-fluid rounded shadow"
                     alt="{{ $course->title }}">
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container my-5">
    <div class="row">

        <div class="col-lg-8">
            <!-- Description -->
            <div class="card shadow-sm mb-4 rounded-4">
                <div class="card-header bg-white">
                    <h4 class="fw-bold">Course Description</h4>
                </div>
                <div class="card-body">{!! nl2br(e($course->full_description)) !!}</div>
            </div>

            <!-- Curriculum -->
            <div class="card shadow-sm mb-4 rounded-4">
                <div class="card-header bg-white">
                    <h4 class="fw-bold">Curriculum</h4>
                </div>
                <div class="card-body">
                    @if($course->curriculum_file)
                        <a href="{{ asset('uploads/curriculum/' . $course->curriculum_file) }}" 
                           class="btn btn-outline-primary rounded-pill hover-scale" download>
                            <i class="bi bi-file-earmark-pdf"></i> Download Curriculum
                        </a>
                    @else
                        <p>No curriculum uploaded.</p>
                    @endif
                </div>
            </div>

            <!-- Location / Live Training -->
            @if($course->type === 'onsite')
            <div class="card shadow-sm mb-4 rounded-4">
                <div class="card-header bg-white">
                    <h4 class="fw-bold">Training Location</h4>
                </div>
                <div class="card-body">
                    <p><i class="bi bi-geo-alt"></i> {{ $course->location }}</p>
                </div>
            </div>
            @endif

            @if($course->type === 'online' && $course->online_type === 'live')
            <div class="card shadow-sm mb-4 rounded-4">
                <div class="card-header bg-white">
                    <h4 class="fw-bold">Live Training Link</h4>
                </div>
                <div class="card-body">
                    <p>Meeting Link: <a href="{{ $course->meeting_link }}" target="_blank" class="text-decoration-none">Join Live Class</a></p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card sticky-top shadow-sm rounded-4" style="top: 100px;">
                <div class="card-body text-center">
                    <h3 class="fw-bold mb-3">${{ number_format($course->price, 2) }}</h3>
                    <button class="btn btn-aspro btn-lg w-100 mb-3 hover-scale" data-bs-toggle="modal" data-bs-target="#checkoutModal">Enroll Now</button>
                    <hr>
                    <ul class="list-unstyled text-start">
                        <li><i class="bi bi-check-circle text-success me-2"></i> Lifetime Access</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i> Certificate Included</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i> 24/7 Support</li>
                        <li><i class="bi bi-check-circle text-success me-2"></i> Downloadable Materials</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      @guest
          <div class="modal-body text-center p-5">
              <h4>You must be logged in to continue</h4>
              <a href="{{ route('register') }}" class="btn btn-aspro mt-3 hover-scale">Create Account</a>
              <a href="{{ route('login') }}" class="btn btn-secondary mt-2 hover-scale">Login</a>
          </div>
      @else
          <div class="modal-header">
              <h5 class="modal-title">Checkout</h5>
          </div>
          <div class="modal-body">
              <p>You are about to enroll into:</p>
              <h4>{{ $course->title }}</h4>
              <p class="fw-bold">Price: ${{ number_format($course->price, 2) }}</p>
          </div>
          <div class="modal-footer">
              <a href="{{ route('courses.enroll', $course->id) }}" class="btn btn-aspro hover-scale">
                 Proceed to Payment
              </a>
          </div>
      @endguest

    </div>
  </div>
</div>

@endsection

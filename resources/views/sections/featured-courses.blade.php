<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Featured Courses</h2>
            <p class="text-muted">Start your journey to professional certification with our top-rated courses</p>
        </div>

        <div class="row g-4">
            @foreach($featuredCourses as $course)
                <div class="col-md-6 col-lg-4">
                    <div class="card aspro-course-card shadow-sm">

                        <img src="{{ $course->image ? asset($course->image) : asset('assets/images/course-default.jpg') }}" 
                             class="card-img-top" 
                             alt="{{ $course->title }}">

                        <div class="card-body">

                            <span class="badge bg-aspro-primary mb-2">Certification</span>
                            <h5 class="fw-semibold course-title">{{ $course->title }}</h5>

                            <div class="aspro-rating mb-2">
                                <span class="text-warning">★★★★☆</span>
                                <small class="text-muted ms-1">(4.8)</small>
                            </div>

                            <p class="text-muted small mb-3">{{ $course->short_desc }}</p>

                            <div class="d-flex justify-content-between text-muted small mb-3">
                                <span><i class="bi bi-clock"></i> {{ $course->duration }}</span>
                                <span><i class="bi bi-people"></i> {{ $course->students ?? '0' }} enrolled</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <span class="fw-bold text-aspro-primary fs-5">${{ $course->price }}</span>
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-aspro btn-sm">
                                    View Details
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('courses.index') }}" class="btn btn-aspro-outline btn-lg px-5">View All Courses</a>
        </div>
    </div>
</section>

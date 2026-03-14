@extends('layouts.app')
@section('title', 'About Us | AsproHubs')
@section('meta_description', 'ASPRO Business Solutions — a leading professional training and consulting firm committed to developing high-impact talent.')

@section('content')

{{-- ── Hero ── --}}
<div class="relative bg-[var(--aspro-dark)] py-20 overflow-hidden">
    <div class="pointer-events-none absolute inset-0 opacity-5"
         style="background: radial-gradient(circle at 70% 50%, #4f46e5 0%, transparent 60%)"></div>
    <div class="relative max-w-7xl mx-auto px-6 text-center">
        <span class="inline-block rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-widest mb-5
                     bg-[var(--aspro-primary-light)] text-[var(--aspro-primary)]">
            About Us
        </span>
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white leading-tight max-w-3xl mx-auto">
            Developing High-Impact Talent for a Competitive World
        </h1>
        <p class="mt-5 text-lg text-slate-300 max-w-2xl mx-auto">
            ASPRO Business Solutions is a leading professional training and consulting firm
            committed to practical, results-driven learning across Africa, Europe, and the Middle East.
        </p>
    </div>
</div>

{{-- ── Who We Are ── --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-14 items-center">

            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-[var(--aspro-primary)]">
                    Who We Are
                </span>
                <h2 class="mt-3 text-3xl font-extrabold text-gray-900 leading-snug">
                    Over 14 Years of Professional Excellence
                </h2>
                <p class="mt-5 text-gray-600 leading-relaxed">
                    ASPRO Business Solutions is a leading professional training and consulting firm committed
                    to developing high-impact talent and delivering practical, results-driven learning solutions.
                    We specialise in professional certification preparation, technical skills development, and
                    organisational capability building.
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    Our approach combines industry expertise, real-world application, and learner-centred
                    delivery to ensure measurable value for both individuals and organisations.
                </p>

                {{-- Trusted by --}}
                <div class="mt-8 pt-6 border-t border-gray-100">
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">
                        Trusted by Leading Organisations
                    </p>
                    <div class="flex flex-wrap gap-3">
                        @foreach(['MTN','NNPC/NAPIMS','NLNG','CBN','ARM','PZ Cussons'] as $org)
                        <span class="rounded-lg border border-gray-200 bg-gray-50 px-3 py-1.5
                                     text-sm font-semibold text-gray-700">
                            {{ $org }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-5">
                @php
                $stats = [
                    ['value' => '14+',    'label' => 'Years of Excellence',       'icon' => '🏆'],
                    ['value' => '5,000+', 'label' => 'Professionals Trained',     'icon' => '👥'],
                    ['value' => '9+',     'label' => 'Professional Courses',      'icon' => '📚'],
                    ['value' => '98%',    'label' => 'Learner Satisfaction Rate', 'icon' => '⭐'],
                ];
                @endphp
                @foreach($stats as $stat)
                <div class="rounded-2xl border border-gray-200 bg-[var(--aspro-light)] p-6 text-center">
                    <div class="text-3xl mb-3">{{ $stat['icon'] }}</div>
                    <p class="text-3xl font-extrabold text-[var(--aspro-primary)]"
                       style="font-family:'Syne',sans-serif;">
                        {{ $stat['value'] }}
                    </p>
                    <p class="mt-1 text-sm text-gray-500">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>

{{-- ── Vision & Mission ── --}}
<section class="py-20 bg-[var(--aspro-light)]">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 gap-8">

            {{-- Vision --}}
            <div class="rounded-2xl bg-white border border-[var(--aspro-border)] p-8 shadow-sm">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl text-2xl
                            bg-[var(--aspro-primary-light)]">
                    🎯
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-3">Our Vision</h3>
                <p class="text-gray-600 leading-relaxed">
                    To be a trusted global partner in professional development, empowering individuals
                    and organisations to build capability, resilience, and long-term success in a
                    rapidly evolving world.
                </p>
            </div>

            {{-- Mission --}}
            <div class="rounded-2xl bg-white border border-[var(--aspro-border)] p-8 shadow-sm">
                <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl text-2xl
                            bg-[var(--aspro-primary-light)]">
                    🚀
                </div>
                <h3 class="text-xl font-extrabold text-gray-900 mb-3">Our Mission</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    To deliver high-quality, industry-relevant training and advisory services that enable
                    professionals and organisations to build competence, adaptability, and sustainable performance.
                </p>
                <ul class="space-y-2">
                    @foreach([
                        'Providing practical, outcome-focused learning experiences',
                        'Bridging the gap between theory and real-world application',
                        'Supporting continuous professional growth and organisational excellence',
                    ] as $item)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <span class="mt-1 flex-shrink-0 font-bold" style="color:var(--aspro-primary)">✓</span>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ── Core Values ── --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-xs font-bold uppercase tracking-widest text-[var(--aspro-primary)]">
                What We Stand For
            </span>
            <h2 class="mt-3 text-3xl font-extrabold text-gray-900">Our Core Values</h2>
        </div>

        @php
        $values = [
            [
                'icon'  => '🌟',
                'title' => 'Excellence',
                'desc'  => 'We uphold the highest standards in training delivery, content quality, and client engagement to ensure meaningful learning outcomes.',
            ],
            [
                'icon'  => '🤝',
                'title' => 'Integrity',
                'desc'  => 'We operate with honesty, transparency, and accountability in all our professional relationships.',
            ],
            [
                'icon'  => '⚡',
                'title' => 'Practical Impact',
                'desc'  => 'We focus on real-world applicability, ensuring our solutions deliver measurable value and workplace impact.',
            ],
            [
                'icon'  => '💪',
                'title' => 'Resilience',
                'desc'  => 'We empower individuals and organisations to adapt, evolve, and thrive in changing environments by building capability, confidence, and agility.',
            ],
            [
                'icon'  => '🔄',
                'title' => 'Continuous Improvement',
                'desc'  => 'We are committed to ongoing learning, innovation, and improvement to remain relevant in a fast-changing professional landscape.',
            ],
            [
                'icon'  => '🤲',
                'title' => 'Partnership',
                'desc'  => 'We work collaboratively with our clients, building trusted, long-term relationships grounded in shared success.',
            ],
        ];
        @endphp

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($values as $val)
            <div class="rounded-2xl border border-[var(--aspro-border)] bg-[var(--aspro-light)] p-6
                        hover:shadow-md hover:border-[var(--aspro-primary)] transition">
                <div class="mb-4 text-3xl">{{ $val['icon'] }}</div>
                <h3 class="font-bold text-gray-900 mb-2">{{ $val['title'] }}</h3>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $val['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── CTA ── --}}
<section class="py-16" style="background: linear-gradient(135deg, var(--aspro-primary) 0%, #7c3aed 100%)">
    <div class="max-w-4xl mx-auto px-6 text-center text-white">
        <h2 class="text-3xl font-extrabold mb-4">Ready to Grow with Us?</h2>
        <p class="text-indigo-200 text-lg mb-8 max-w-xl mx-auto">
            Join thousands of professionals who have advanced their careers with AsproHubs.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('courses.index') }}"
               class="inline-flex items-center justify-center rounded-xl bg-white px-7 py-3
                      font-bold shadow transition hover:bg-indigo-50"
               style="color:var(--aspro-primary)">
                Browse Courses
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center justify-center rounded-xl border-2 border-white
                      px-7 py-3 font-bold text-white hover:bg-white/10 transition">
                Contact Us
            </a>
        </div>
    </div>
</section>

@endsection
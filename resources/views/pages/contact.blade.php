@extends('layouts.app')
@section('title', 'Contact Us | AsproHubs')
@section('meta_description', 'Get in touch with AsproHubs — we respond within 24 hours.')

@section('content')

{{-- ── Hero ── --}}
<div class="bg-[var(--aspro-dark)] py-16">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <span class="inline-block rounded-full px-4 py-1.5 text-xs font-bold uppercase tracking-widest mb-5
                     bg-[var(--aspro-primary-light)] text-[var(--aspro-primary)]">
            Contact Us
        </span>
        <h1 class="text-4xl font-extrabold text-white">Get in Touch</h1>
        <p class="mt-3 text-slate-300 text-lg max-w-lg mx-auto">
            Have questions? We'd love to hear from you. Send us a message and we'll respond within 24 hours.
        </p>
    </div>
</div>

{{-- ── Contact Cards + Form ── --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- ── Left: Contact Info ── --}}
            <div class="space-y-5">

                <h2 class="text-xl font-extrabold text-gray-900 mb-6" style="font-family:'Syne',sans-serif;">
                    Contact Information
                </h2>

                {{-- Email --}}
                <div class="flex items-start gap-4 rounded-2xl border border-[var(--aspro-border)]
                            bg-[var(--aspro-light)] p-5">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center
                                rounded-xl bg-[var(--aspro-primary-light)] text-xl">
                        ✉️
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-0.5">Email</p>
                        <a href="mailto:info@asprobusiness.com"
                           class="text-sm font-semibold text-gray-900 hover:text-[var(--aspro-primary)] transition">
                            info@asprobusiness.com
                        </a>
                    </div>
                </div>

                {{-- Phone --}}
                <div class="flex items-start gap-4 rounded-2xl border border-[var(--aspro-border)]
                            bg-[var(--aspro-light)] p-5">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center
                                rounded-xl bg-[var(--aspro-primary-light)] text-xl">
                        📞
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-0.5">Phone</p>
                        <a href="tel:08033202344"
                           class="text-sm font-semibold text-gray-900 hover:text-[var(--aspro-primary)] transition block">
                            08033202344
                        </a>
                        <a href="tel:08032515225"
                           class="text-sm font-semibold text-gray-900 hover:text-[var(--aspro-primary)] transition block mt-0.5">
                            08032515225
                        </a>
                    </div>
                </div>

                {{-- Location --}}
                <div class="flex items-start gap-4 rounded-2xl border border-[var(--aspro-border)]
                            bg-[var(--aspro-light)] p-5">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center
                                rounded-xl bg-[var(--aspro-primary-light)] text-xl">
                        📍
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-0.5">Location</p>
                        <p class="text-sm font-semibold text-gray-900">
                            Agos Building, 54b Adeniyi Jones Road,<br>
                            Ikeja, Lagos
                        </p>
                    </div>
                </div>

                {{-- Hours --}}
                <div class="flex items-start gap-4 rounded-2xl border border-[var(--aspro-border)]
                            bg-[var(--aspro-light)] p-5">
                    <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center
                                rounded-xl bg-[var(--aspro-primary-light)] text-xl">
                        🕐
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-0.5">Business Hours</p>
                        <p class="text-sm font-semibold text-gray-900">Monday – Friday</p>
                        <p class="text-sm text-gray-500">9:00 AM – 5:00 PM WAT</p>
                    </div>
                </div>

            </div>

            {{-- ── Right: Contact Form ── --}}
            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-[var(--aspro-border)] bg-white p-8 shadow-sm">
                    <h2 class="text-xl font-extrabold text-gray-900 mb-1" style="font-family:'Syne',sans-serif;">
                        Send Us a Message
                    </h2>
                    <p class="text-sm text-gray-400 mb-7">We'll get back to you within 24 hours.</p>

                    {{-- Flash success --}}
                    @if(session('success'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">
                        ✅ {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
                        @csrf

                        <div class="grid sm:grid-cols-2 gap-5">
                            {{-- Name --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       placeholder="Your full name"
                                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm
                                              focus:outline-none focus:border-[var(--aspro-primary)]
                                              focus:ring-1 focus:ring-[var(--aspro-primary)]
                                              @error('name') border-red-400 bg-red-50 @enderror"/>
                                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       placeholder="you@email.com"
                                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm
                                              focus:outline-none focus:border-[var(--aspro-primary)]
                                              focus:ring-1 focus:ring-[var(--aspro-primary)]
                                              @error('email') border-red-400 bg-red-50 @enderror"/>
                                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-5">
                            {{-- Phone --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Phone Number
                                </label>
                                <input type="tel" name="phone" value="{{ old('phone') }}"
                                       placeholder="+234 800 000 0000"
                                       class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm
                                              focus:outline-none focus:border-[var(--aspro-primary)]
                                              focus:ring-1 focus:ring-[var(--aspro-primary)]"/>
                            </div>

                            {{-- Subject --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Subject <span class="text-red-500">*</span>
                                </label>
                                <select name="subject" required
                                        class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm
                                               focus:outline-none focus:border-[var(--aspro-primary)]
                                               focus:ring-1 focus:ring-[var(--aspro-primary)]">
                                    <option value="">— select —</option>
                                    @foreach([
                                        'Course Enquiry',
                                        'Corporate / Group Training',
                                        'Pricing & Payment',
                                        'Technical Support',
                                        'Partnership Enquiry',
                                        'Other',
                                    ] as $subj)
                                    <option value="{{ $subj }}" {{ old('subject') === $subj ? 'selected' : '' }}>
                                        {{ $subj }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('subject')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Organisation --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Organisation <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <input type="text" name="organisation" value="{{ old('organisation') }}"
                                   placeholder="Your company or organisation"
                                   class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm
                                          focus:outline-none focus:border-[var(--aspro-primary)]
                                          focus:ring-1 focus:ring-[var(--aspro-primary)]"/>
                        </div>

                        {{-- Message --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea name="message" rows="5" required
                                      placeholder="Tell us how we can help…"
                                      class="w-full resize-none rounded-xl border border-gray-300 px-4 py-2.5
                                             text-sm focus:outline-none focus:border-[var(--aspro-primary)]
                                             focus:ring-1 focus:ring-[var(--aspro-primary)]
                                             @error('message') border-red-400 bg-red-50 @enderror"
                            >{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit"
                                class="w-full rounded-xl py-3 font-bold text-white shadow-md transition
                                       hover:opacity-90 active:scale-[0.98]"
                                style="background:var(--aspro-primary)">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── FAQs ── --}}
<section class="py-20 bg-[var(--aspro-light)]">
    <div class="max-w-4xl mx-auto px-6">

        <div class="text-center mb-12">
            <span class="text-xs font-bold uppercase tracking-widest text-[var(--aspro-primary)]">
                FAQs
            </span>
            <h2 class="mt-3 text-3xl font-extrabold text-gray-900">Frequently Asked Questions</h2>
        </div>

        @php
        $faqs = [
            [
                'q' => 'How do I enroll in a course?',
                'a' => 'Visit our Courses page, select the programme you want, and click "Enroll Now." You\'ll be guided through creating an account, completing your registration form, and our team will review and confirm your enrolment within 24 hours.',
            ],
            [
                'q' => 'What payment methods do you accept?',
                'a' => 'We accept all major credit and debit cards, and payments are processed securely online. If you need corporate invoicing or alternative payment options (e.g., bank transfer), please contact us directly.',
            ],
            [
                'q' => 'Do you offer corporate or customised training?',
                'a' => 'Yes — we provide fully customised training solutions for organisations, tailored to your team\'s needs. Reach out to us with your training objectives and number of participants to get a bespoke proposal.',
            ],
            [
                'q' => 'How soon will you respond if I contact support?',
                'a' => 'We strive to reply within 24 hours to all enquiries submitted through our contact form or email.',
            ],
            [
                'q' => 'Can I speak to someone directly?',
                'a' => 'Yes — you can reach our support team via phone or email. Our team is available during business hours (Mon–Fri, 9 AM–5 PM WAT) to answer questions and help you register or choose the right course.',
            ],
            [
                'q' => 'Where are you located and what are your business hours?',
                'a' => 'Our office is at Agos Building, 54b Adeniyi Jones Road, Ikeja, Lagos. Business hours are Monday–Friday, 9:00 AM–5:00 PM WAT.',
            ],
            [
                'q' => 'Do you offer support after course completion?',
                'a' => 'Yes — we provide post-training support to help you apply what you\'ve learned and answer follow-up questions related to your training.',
            ],
            [
                'q' => 'Can I subscribe for updates on new courses?',
                'a' => 'Absolutely! You can contact us to stay updated on new courses, training opportunities, and special offers.',
            ],
        ];
        @endphp

        <div class="space-y-3" x-data="{ open: null }">
            @foreach($faqs as $i => $faq)
            <div class="rounded-2xl border border-[var(--aspro-border)] bg-white overflow-hidden shadow-sm">
                <button
                    @click="open = open === {{ $i }} ? null : {{ $i }}"
                    class="flex w-full items-center justify-between px-6 py-4 text-left
                           hover:bg-[var(--aspro-light)] transition"
                >
                    <span class="font-semibold text-gray-900 pr-4">{{ $faq['q'] }}</span>
                    <svg class="h-5 w-5 flex-shrink-0 transition-transform duration-200 text-[var(--aspro-primary)]"
                         :class="open === {{ $i }} ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $i }}"
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="border-t border-[var(--aspro-border)] px-6 py-4">
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <p class="mt-10 text-center text-sm text-gray-500">
            Still have questions?
            <a href="mailto:info@asprobusiness.com"
               class="font-semibold hover:underline" style="color:var(--aspro-primary)">
                Email us directly →
            </a>
        </p>
    </div>
</section>

@endsection
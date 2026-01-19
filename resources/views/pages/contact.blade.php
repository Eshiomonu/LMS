@extends('layouts.app')

@section('title', 'Contact Us | AsproHubs')
@section('meta_description', 'Get in touch with AsproHubs for courses, training, and corporate learning solutions.')

@section('content')

    {{-- Banner --}}
    <section class="bg-[var(--aspro-primary)] py-20">
        <div class="max-w-7xl mx-auto px-6 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-extrabold">
                Contact Us
            </h1>
            <p class="mt-4 text-lg text-white/90">
                We’d love to hear from you. Let’s start a conversation.
            </p>
        </div>
    </section>

    {{-- Contact Section --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-3 gap-10">

            {{-- Contact Form --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Send us a Message
                    </h2>
                    <p class="text-sm text-gray-500">
                        We respond within 24 hours
                    </p>
                </div>

                <form class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-1">Full Name</label>
                        <input type="text"
                               class="w-full rounded-xl border-gray-300 focus:border-[var(--aspro-primary)] focus:ring-[var(--aspro-primary)]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Email Address</label>
                        <input type="email"
                               class="w-full rounded-xl border-gray-300 focus:border-[var(--aspro-primary)] focus:ring-[var(--aspro-primary)]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Phone Number</label>
                        <input type="text"
                               class="w-full rounded-xl border-gray-300 focus:border-[var(--aspro-primary)] focus:ring-[var(--aspro-primary)]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Subject</label>
                        <input type="text"
                               class="w-full rounded-xl border-gray-300 focus:border-[var(--aspro-primary)] focus:ring-[var(--aspro-primary)]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Message</label>
                        <textarea rows="5"
                                  class="w-full rounded-xl border-gray-300 focus:border-[var(--aspro-primary)] focus:ring-[var(--aspro-primary)]"></textarea>
                    </div>

                    <button type="submit"
                            class="w-full py-3 rounded-xl bg-[var(--aspro-primary)]
                                   text-white font-semibold hover:bg-[var(--aspro-primary-dark)] transition">
                        Send Message
                    </button>
                </form>
            </div>

            {{-- Right Sidebar --}}
            <div class="space-y-8">

                {{-- Contact Info --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-xl font-semibold mb-4">
                        Contact Information
                    </h3>

                    <ul class="space-y-4 text-sm text-gray-700">
                        <li class="flex gap-3">
                            <span class="text-[var(--aspro-primary)]">✉</span>
                            info@asprobusiness.com
                        </li>
                        <li class="flex gap-3">
                            <span class="text-[var(--aspro-primary)]">☎</span>
                            +1 (555) 123-4567
                        </li>
                        <li class="flex gap-3">
                            <span class="text-[var(--aspro-primary)]">📍</span>
                            123 Business Park, Suite 400, New York, NY 10001
                        </li>
                        <li class="flex gap-3">
                            <span class="text-[var(--aspro-primary)]">🕘</span>
                            Mon–Fri: 9:00 AM – 6:00 PM
                        </li>
                    </ul>
                </div>

                {{-- FAQ --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">
                    <h3 class="text-xl font-semibold mb-4">
                        Frequently Asked Questions
                    </h3>

                    <div class="space-y-4 text-sm">
                        <div>
                            <h4 class="font-semibold">
                                How do I enroll in a course?
                            </h4>
                            <p class="text-gray-600">
                                Browse the course catalog, select a course, and click “Register Now”.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold">
                                What payment methods do you accept?
                            </h4>
                            <p class="text-gray-600">
                                We accept all major credit cards and process payments securely.
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold">
                                Do you offer corporate training?
                            </h4>
                            <p class="text-gray-600">
                                Yes, we provide fully customized training solutions for organizations.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

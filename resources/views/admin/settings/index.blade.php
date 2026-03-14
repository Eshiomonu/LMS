@extends('layouts.admin')
@section('title', 'Settings')
@section('page-title', 'Settings')
@section('page-subtitle', 'Manage platform configuration, mail, and payment settings')

@push('styles')
<style>
    .form-label { display:block; font-size:13px; font-weight:600; color:#374151; margin-bottom:5px; }
    .form-input { width:100%; border-radius:10px; border:1px solid #e2e8f0; padding:9px 12px; font-size:13.5px; color:#0f172a; outline:none; transition:border-color .15s; background:#fff; }
    .form-input:focus { border-color:#4f46e5; box-shadow:0 0 0 3px rgba(79,70,229,.1); }
    select.form-input { appearance:auto; }
    .form-error { color:#dc2626; font-size:12px; margin-top:4px; }
    .tab-btn { padding:10px 18px; font-size:13.5px; font-weight:600; border-radius:10px; cursor:pointer; transition:all .15s; color:#64748b; }
    .tab-btn.active, .tab-btn:hover { background:#eef2ff; color:#4f46e5; }
</style>
@endpush

@section('content')
@php
$g = $settings['general'] ?? [];
$m = $settings['mail']    ?? [];
$p = $settings['payment'] ?? [];
@endphp

<div x-data="{ tab: '{{ request('tab','general') }}' }">

    {{-- Tab bar --}}
    <div class="mb-6 flex gap-1 rounded-2xl border border-slate-200 bg-white p-1.5 shadow-sm w-fit">
        @foreach(['general'=>'⚙️  General','mail'=>'✉️  Mail / SMTP','payment'=>'💳  Payment'] as $key=>$label)
        <button @click="tab = '{{ $key }}'"
                :class="tab === '{{ $key }}' ? 'active' : ''"
                class="tab-btn">
            {{ $label }}
        </button>
        @endforeach
    </div>

    {{-- ─── GENERAL ─── --}}
    <div x-show="tab === 'general'" x-cloak>
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

                {{-- Site identity --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                        Site Identity
                    </h3>

                    <div>
                        <label class="form-label">Site Name <span class="text-red-500">*</span></label>
                        <input type="text" name="site_name"
                               value="{{ old('site_name', $g['site_name'] ?? 'AsproHubs') }}"
                               required class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">Tagline</label>
                        <input type="text" name="site_tagline"
                               value="{{ old('site_tagline', $g['site_tagline'] ?? '') }}"
                               placeholder="e.g. Learn. Grow. Succeed."
                               class="form-input" />
                    </div>

                    {{-- Logo upload --}}
                    <div>
                        <label class="form-label">Site Logo</label>
                        @if(!empty($g['site_logo']))
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$g['site_logo']) }}"
                                 class="h-12 object-contain" alt="Logo" />
                        </div>
                        @endif
                        <form method="POST" action="{{ route('admin.settings.logo') }}"
                              enctype="multipart/form-data" class="flex items-center gap-2">
                            @csrf
                            <input type="file" name="logo" accept="image/*"
                                   class="block text-sm text-slate-500
                                          file:mr-3 file:rounded-xl file:border-0
                                          file:bg-indigo-50 file:px-4 file:py-2
                                          file:text-sm file:font-semibold file:text-indigo-700
                                          hover:file:bg-indigo-100" />
                            <button type="submit"
                                    class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-bold
                                           text-white hover:bg-indigo-700 transition flex-shrink-0">
                                Upload
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Contact info --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                        Contact Info
                    </h3>
                    <div>
                        <label class="form-label">Support Email <span class="text-red-500">*</span></label>
                        <input type="email" name="support_email"
                               value="{{ old('support_email', $g['support_email'] ?? 'info@asprohubs.com') }}"
                               required class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">Support Phone</label>
                        <input type="text" name="support_phone"
                               value="{{ old('support_phone', $g['support_phone'] ?? '') }}"
                               class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">Address</label>
                        <textarea name="support_address" rows="2" class="form-input">{{ old('support_address', $g['support_address'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Platform config --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                        Platform Config
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">Default Currency</label>
                            <select name="currency" class="form-input">
                                @foreach(['NGN','USD','GBP','EUR'] as $c)
                                <option value="{{ $c }}" @selected(($g['currency']??'NGN')===$c)>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Currency Symbol</label>
                            <input type="text" name="currency_symbol"
                                   value="{{ old('currency_symbol', $g['currency_symbol'] ?? '₦') }}"
                                   class="form-input" />
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Enrollment Mode</label>
                        <select name="enrollment_mode" class="form-input">
                            @foreach(['open'=>'Open (anyone can enroll)','review'=>'Review (admin approves each enrollment)','closed'=>'Closed (no new enrollments)'] as $val=>$lbl)
                            <option value="{{ $val }}" @selected(($g['enrollment_mode']??'review')===$val)>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Social & Footer --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                        Social & Footer
                    </h3>
                    @foreach(['facebook_url'=>'Facebook URL','twitter_url'=>'Twitter / X URL','instagram_url'=>'Instagram URL','linkedin_url'=>'LinkedIn URL'] as $key=>$lbl)
                    <div>
                        <label class="form-label">{{ $lbl }}</label>
                        <input type="url" name="{{ $key }}"
                               value="{{ old($key, $g[$key] ?? '') }}"
                               placeholder="https://"
                               class="form-input" />
                    </div>
                    @endforeach
                    <div>
                        <label class="form-label">Footer Text</label>
                        <input type="text" name="footer_text"
                               value="{{ old('footer_text', $g['footer_text'] ?? '© '.date('Y').' AsproHubs. All rights reserved.') }}"
                               class="form-input" />
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="rounded-xl px-8 py-3 text-sm font-bold text-white shadow-sm
                               transition hover:opacity-90" style="background:var(--brand)">
                    Save General Settings
                </button>
            </div>
        </form>
    </div>

    {{-- ─── MAIL ─── --}}
    <div x-show="tab === 'mail'" x-cloak>
        <form method="POST" action="{{ route('admin.settings.mail') }}">
            @csrf @method('PUT')

            <div class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-5">
                <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                    Mail / SMTP Configuration
                </h3>
                <p class="text-sm text-slate-400 -mt-2">
                    Configure outgoing email. These values map to your <code class="bg-slate-100 px-1 rounded">.env</code> MAIL_* variables.
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Mail Driver</label>
                        <select name="mail_driver" class="form-input">
                            @foreach(['smtp'=>'SMTP','sendmail'=>'Sendmail','log'=>'Log (Dev)','mailgun'=>'Mailgun','ses'=>'Amazon SES'] as $v=>$l)
                            <option value="{{ $v }}" @selected(($m['mail_driver']??'smtp')===$v)>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Encryption</label>
                        <select name="mail_encryption" class="form-input">
                            <option value="tls" @selected(($m['mail_encryption']??'tls')==='tls')>TLS</option>
                            <option value="ssl" @selected(($m['mail_encryption']??'')==='ssl')>SSL</option>
                            <option value="" @selected(($m['mail_encryption']??'')==='')>None</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 sm:col-span-1">
                        <label class="form-label">SMTP Host</label>
                        <input type="text" name="mail_host"
                               value="{{ old('mail_host', $m['mail_host'] ?? 'smtp.mailtrap.io') }}"
                               class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">SMTP Port</label>
                        <input type="number" name="mail_port"
                               value="{{ old('mail_port', $m['mail_port'] ?? 587) }}"
                               class="form-input" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">SMTP Username</label>
                        <input type="text" name="mail_username"
                               value="{{ old('mail_username', $m['mail_username'] ?? '') }}"
                               class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">SMTP Password</label>
                        <input type="password" name="mail_password"
                               placeholder="Leave blank to keep current"
                               class="form-input" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">From Address <span class="text-red-500">*</span></label>
                        <input type="email" name="mail_from_address" required
                               value="{{ old('mail_from_address', $m['mail_from_address'] ?? 'noreply@asprohubs.com') }}"
                               class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">From Name <span class="text-red-500">*</span></label>
                        <input type="text" name="mail_from_name" required
                               value="{{ old('mail_from_name', $m['mail_from_name'] ?? 'AsproHubs') }}"
                               class="form-input" />
                    </div>
                </div>

                <button type="submit"
                        class="rounded-xl px-8 py-3 text-sm font-bold text-white shadow-sm
                               transition hover:opacity-90" style="background:var(--brand)">
                    Save Mail Settings
                </button>
            </div>
        </form>
    </div>

    {{-- ─── PAYMENT ─── --}}
    <div x-show="tab === 'payment'" x-cloak>
        <form method="POST" action="{{ route('admin.settings.payment') }}">
            @csrf @method('PUT')

            <div class="max-w-2xl rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-5">
                <h3 class="font-extrabold text-slate-900" style="font-family:'Syne',sans-serif;">
                    Payment Gateway
                </h3>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Gateway</label>
                        <select name="payment_gateway" class="form-input"
                                x-data x-model="$store.gateway ?? '{{ $p['payment_gateway'] ?? 'manual' }}'">
                            <option value="paystack" @selected(($p['payment_gateway']??'manual')==='paystack')>Paystack</option>
                            <option value="flutterwave" @selected(($p['payment_gateway']??'manual')==='flutterwave')>Flutterwave</option>
                            <option value="manual" @selected(($p['payment_gateway']??'manual')==='manual')>Manual / Bank Transfer</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Mode</label>
                        <select name="payment_mode" class="form-input">
                            <option value="test" @selected(($p['payment_mode']??'test')==='test')>Test / Sandbox</option>
                            <option value="live" @selected(($p['payment_mode']??'test')==='live')>Live / Production</option>
                        </select>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 space-y-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Paystack Keys</p>
                    <div>
                        <label class="form-label">Paystack Public Key</label>
                        <input type="text" name="paystack_public_key"
                               value="{{ old('paystack_public_key', $p['paystack_public_key'] ?? '') }}"
                               placeholder="pk_test_…" class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">Paystack Secret Key</label>
                        <input type="password" name="paystack_secret_key"
                               placeholder="Leave blank to keep current"
                               class="form-input" />
                    </div>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 space-y-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Flutterwave Keys</p>
                    <div>
                        <label class="form-label">Flutterwave Public Key</label>
                        <input type="text" name="flutterwave_public_key"
                               value="{{ old('flutterwave_public_key', $p['flutterwave_public_key'] ?? '') }}"
                               placeholder="FLWPUBK_TEST-…" class="form-input" />
                    </div>
                    <div>
                        <label class="form-label">Flutterwave Secret Key</label>
                        <input type="password" name="flutterwave_secret_key"
                               placeholder="Leave blank to keep current"
                               class="form-input" />
                    </div>
                </div>

                <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 space-y-4">
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Bank Transfer (Manual)</p>
                    <div>
                        <label class="form-label">Bank Name</label>
                        <input type="text" name="bank_name"
                               value="{{ old('bank_name', $p['bank_name'] ?? '') }}"
                               class="form-input" />
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">Account Name</label>
                            <input type="text" name="bank_account_name"
                                   value="{{ old('bank_account_name', $p['bank_account_name'] ?? '') }}"
                                   class="form-input" />
                        </div>
                        <div>
                            <label class="form-label">Account Number</label>
                            <input type="text" name="bank_account_number"
                                   value="{{ old('bank_account_number', $p['bank_account_number'] ?? '') }}"
                                   class="form-input" />
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="rounded-xl px-8 py-3 text-sm font-bold text-white shadow-sm
                               transition hover:opacity-90" style="background:var(--brand)">
                    Save Payment Settings
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
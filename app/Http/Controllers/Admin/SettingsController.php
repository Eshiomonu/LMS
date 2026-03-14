<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::allByGroup();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name'        => ['required', 'string', 'max:100'],
            'site_tagline'     => ['nullable', 'string', 'max:200'],
            'support_email'    => ['required', 'email'],
            'support_phone'    => ['nullable', 'string', 'max:30'],
            'support_address'  => ['nullable', 'string', 'max:500'],
            'currency'         => ['required', 'string', 'max:3'],
            'currency_symbol'  => ['required', 'string', 'max:5'],
            'enrollment_mode'  => ['required', 'in:open,review,closed'],
            'facebook_url'     => ['nullable', 'url'],
            'twitter_url'      => ['nullable', 'url'],
            'instagram_url'    => ['nullable', 'url'],
            'linkedin_url'     => ['nullable', 'url'],
            'footer_text'      => ['nullable', 'string', 'max:300'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'general');
        }

        return back()->with('success', 'General settings saved.');
    }

    public function updateMail(Request $request)
    {
        $data = $request->validate([
            'mail_driver'     => ['required', 'string'],
            'mail_host'       => ['nullable', 'string'],
            'mail_port'       => ['nullable', 'integer'],
            'mail_username'   => ['nullable', 'string'],
            'mail_password'   => ['nullable', 'string'],
            'mail_encryption' => ['nullable', 'in:tls,ssl,'],
            'mail_from_address' => ['required', 'email'],
            'mail_from_name'    => ['required', 'string'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'mail');
        }

        return back()->with('success', 'Mail settings saved.');
    }

    public function updatePayment(Request $request)
    {
        $data = $request->validate([
            'payment_gateway'        => ['required', 'in:paystack,flutterwave,manual'],
            'paystack_public_key'    => ['nullable', 'string'],
            'paystack_secret_key'    => ['nullable', 'string'],
            'flutterwave_public_key' => ['nullable', 'string'],
            'flutterwave_secret_key' => ['nullable', 'string'],
            'payment_mode'           => ['required', 'in:live,test'],
            'bank_name'              => ['nullable', 'string'],
            'bank_account_name'      => ['nullable', 'string'],
            'bank_account_number'    => ['nullable', 'string'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'payment');
        }

        return back()->with('success', 'Payment settings saved.');
    }

    public function uploadLogo(Request $request)
    {
        $request->validate(['logo' => ['required', 'image', 'max:1024']]);
        $old = Setting::get('site_logo');
        if ($old) Storage::disk('public')->delete($old);
        $path = $request->file('logo')->store('site', 'public');
        Setting::set('site_logo', $path, 'general');
        return back()->with('success', 'Logo updated.');
    }
}
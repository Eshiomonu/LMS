<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'subject'      => ['required', 'string', 'max:100'],
            'organisation' => ['nullable', 'string', 'max:255'],
            'message'      => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        // ── Option 1: Mail (configure MAIL_* in .env) ─────────────
        // Mail::to('info@asprobusiness.com')->send(
        //     new \App\Mail\ContactEnquiry($request->all())
        // );

        // ── Option 2: Log to database / queue (placeholder) ───────
        // For now we just redirect with a success message.
        // Add your mail/notification logic here when ready.

        return redirect()->route('contact')
            ->with('success', 'Thank you for your message! We\'ll get back to you within 24 hours.');
    }
}
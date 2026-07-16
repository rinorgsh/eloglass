<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequestMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'service' => ['nullable', 'string', 'max:80'],
            'message' => ['required', 'string', 'max:4000'],
            // Honeypot — must stay empty.
            'website' => ['nullable', 'size:0'],
        ]);

        $to = config('mail.contact_to', 'contact@eloglass.be');

        Mail::to($to)->send(new ContactRequestMail($data));

        return back()->with('contactSuccess', true);
    }
}

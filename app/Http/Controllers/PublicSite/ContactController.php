<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublicSite\StoreContactRequest;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function show(): Response
    {
        $settings = SiteSetting::instance();

        return Inertia::render('public/Contact', [
            'settings' => $settings,
        ]);
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        ContactMessage::create($request->validated());

        return back()->with('success', 'Your message has been sent successfully. We will get back to you soon.');
    }
}

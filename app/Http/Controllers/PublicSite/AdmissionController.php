<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublicSite\StoreAdmissionRequest;
use App\Models\AdmissionApplication;
use App\Models\AdmissionSetting;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AdmissionController extends Controller
{
    public function show(): Response
    {
        $settings = AdmissionSetting::instance();

        return Inertia::render('public/Admission', [
            'admissionSettings' => $settings,
        ]);
    }

    public function store(StoreAdmissionRequest $request): RedirectResponse
    {
        $settings = AdmissionSetting::instance();

        if (! $settings->is_open) {
            return back()->with('error', 'Admission is currently closed.');
        }

        $data = $request->validated();

        // Handle document uploads
        if ($request->hasFile('documents')) {
            $documentPaths = [];
            foreach ($request->file('documents') as $file) {
                $documentPaths[] = $file->store('admissions/documents', 'public');
            }
            $data['documents'] = $documentPaths;
        }

        AdmissionApplication::create($data);

        return back()->with('success', 'Your admission application has been submitted successfully.');
    }
}

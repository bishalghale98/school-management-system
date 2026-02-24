<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdmissionStatusRequest;
use App\Models\AdmissionApplication;
use App\Models\AdmissionSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdmissionController extends Controller
{
    public function index(Request $request): Response
    {
        $query = AdmissionApplication::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $applications = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $settings = AdmissionSetting::instance();

        return Inertia::render('admin/admissions/Index', [
            'applications' => $applications,
            'admissionSettings' => $settings,
            'filters' => $request->only(['status']),
        ]);
    }

    public function show(AdmissionApplication $application): Response
    {
        return Inertia::render('admin/admissions/Show', [
            'application' => $application,
        ]);
    }

    public function updateStatus(UpdateAdmissionStatusRequest $request, AdmissionApplication $application): RedirectResponse
    {
        $application->update($request->validated());

        return back()->with('success', 'Application status updated.');
    }

    public function toggleAdmission(Request $request): RedirectResponse
    {
        $settings = AdmissionSetting::instance();
        $settings->update(['is_open' => ! $settings->is_open]);

        return back()->with('success', 'Admission status updated.');
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => ['nullable', 'string'],
            'requirements' => ['nullable', 'array'],
            'requirements.*' => ['string'],
        ]);

        $settings = AdmissionSetting::instance();
        $settings->update($request->only(['content', 'requirements']));

        return back()->with('success', 'Admission settings updated.');
    }
}

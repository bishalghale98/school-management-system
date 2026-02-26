<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('admin/settings/Edit', [
            'settings' => SiteSetting::instance(),
        ]);
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Handle file uploads
        $imageFields = [
            'logo' => 'settings',
            'about_image' => 'settings',
            'principal_image' => 'settings',
            'welcome_image' => 'settings',
        ];

        foreach ($imageFields as $field => $disk) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store($disk, 'public');
            } else {
                unset($data[$field]);
            }
        }

        // Handle carousel slide image uploads
        if (!empty($data['carousel_slides'])) {
            foreach ($data['carousel_slides'] as $index => &$slide) {
                $fileKey = "carousel_slides.{$index}.image";
                if ($request->hasFile($fileKey)) {
                    $slide['image'] = $request->file($fileKey)->store('settings/carousel', 'public');
                }
                // If it's already a string path, keep it as-is
            }
            unset($slide);
        }

        SiteSetting::instance()->update($data);

        return back()->with('success', 'Settings updated successfully.');
    }
}

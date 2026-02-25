<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublicSite\StoreAdmissionRequest;
use App\Models\AdmissionApplication;
use App\Models\AdmissionSetting;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('public/About');
    }

  
}

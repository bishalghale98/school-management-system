<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('public/About', [
            'settings' => SiteSetting::instance(),
        ]);
    }
}

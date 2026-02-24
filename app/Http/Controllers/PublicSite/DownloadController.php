<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\DownloadCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DownloadController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Download::published()->with('category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $downloads = $query
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->paginate(12)
            ->withQueryString();

        $categories = DownloadCategory::withCount(['downloads' => fn ($q) => $q->published()])->get();

        return Inertia::render('public/Downloads', [
            'downloads' => $downloads,
            'categories' => $categories,
            'filters' => $request->only(['category']),
        ]);
    }
}

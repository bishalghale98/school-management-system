<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use Inertia\Inertia;
use Inertia\Response;

class GalleryController extends Controller
{
    public function index(): Response
    {
        $albums = GalleryAlbum::published()
            ->withCount('photos')
            ->orderByDesc('event_date')
            ->paginate(12);

        return Inertia::render('public/gallery/Index', [
            'albums' => $albums,
        ]);
    }

    public function show(string $slug): Response
    {
        $album = GalleryAlbum::where('slug', $slug)
            ->published()
            ->with(['photos' => fn ($q) => $q->orderBy('sort_order')])
            ->firstOrFail();

        return Inertia::render('public/gallery/Show', [
            'album' => $album,
        ]);
    }
}

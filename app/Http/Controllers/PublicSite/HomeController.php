<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\GalleryAlbum;
use App\Models\Post;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $settings = SiteSetting::instance();

        $latestPosts = Post::published()
            ->with('category')
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $featuredDownloads = Download::published()
            ->featured()
            ->with('category')
            ->limit(6)
            ->get();

        $albums = GalleryAlbum::published()
            ->withCount('photos')
            ->orderByDesc('event_date')
            ->limit(4)
            ->get();

        return Inertia::render('public/Home', [
            'settings' => $settings,
            'latestPosts' => $latestPosts,
            'featuredDownloads' => $featuredDownloads,
            'albums' => $albums,
        ]);
    }
}

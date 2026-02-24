<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\Page;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function show(string $slug): Response
    {
        $page = Page::where('slug', $slug)->published()->firstOrFail();

        $latestPosts = Post::published()
            ->with('category')
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        $featuredDownloads = Download::published()
            ->featured()
            ->limit(5)
            ->get();

        return Inertia::render('public/Page', [
            'page' => $page,
            'latestPosts' => $latestPosts,
            'featuredDownloads' => $featuredDownloads,
            'meta' => [
                'title' => $page->meta_title ?: $page->title,
                'description' => $page->meta_description ?: $page->excerpt,
                'og_image' => $page->og_image,
            ],
        ]);
    }
}

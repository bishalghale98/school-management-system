<?php

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Post::published()->with('category');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $posts = $query
            ->orderByDesc('is_pinned')
            ->orderByDesc('published_at')
            ->paginate(10)
            ->withQueryString();

        $categories = PostCategory::withCount(['posts' => fn ($q) => $q->published()])->get();

        return Inertia::render('public/posts/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category']),
        ]);
    }

    public function show(string $slug): Response
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->with(['category', 'attachments'])
            ->firstOrFail();

        return Inertia::render('public/posts/Show', [
            'post' => $post,
            'meta' => [
                'title' => $post->meta_title ?: $post->title,
                'description' => $post->meta_description ?: $post->excerpt,
                'og_image' => $post->og_image,
            ],
        ]);
    }
}

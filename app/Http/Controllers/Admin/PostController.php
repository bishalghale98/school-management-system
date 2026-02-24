<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Post::with('category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->input('search').'%');
        }

        $posts = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $categories = PostCategory::all();

        return Inertia::render('admin/posts/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'status']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/posts/Create', [
            'categories' => PostCategory::all(),
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('posts/og', 'public');
        }

        unset($data['attachments']);
        $post = Post::create($data);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $post->attachments()->create([
                    'file_path' => $file->store('posts/attachments', 'public'),
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post): Response
    {
        $post->load('attachments');

        return Inertia::render('admin/posts/Edit', [
            'post' => $post,
            'categories' => PostCategory::all(),
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        } else {
            unset($data['featured_image']);
        }
        if ($request->hasFile('og_image')) {
            if ($post->og_image) {
                Storage::disk('public')->delete($post->og_image);
            }
            $data['og_image'] = $request->file('og_image')->store('posts/og', 'public');
        } else {
            unset($data['og_image']);
        }

        unset($data['attachments']);

        // Clean up editor images removed from content
        $this->cleanupRemovedEditorImages($post->content, $data['content'] ?? $post->content);

        $post->update($data);

        // Handle new attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $post->attachments()->create([
                    'file_path' => $file->store('posts/attachments', 'public'),
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        if ($post->og_image) {
            Storage::disk('public')->delete($post->og_image);
        }
        foreach ($post->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        // Delete inline editor images from content
        $this->deleteEditorImages($post->content);

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    public function deleteAttachment(Post $post, int $attachmentId): RedirectResponse
    {
        $attachment = $post->attachments()->findOrFail($attachmentId);
        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return back()->with('success', 'Attachment deleted.');
    }
}

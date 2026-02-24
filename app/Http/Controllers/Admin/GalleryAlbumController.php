<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAlbumRequest;
use App\Http\Requests\Admin\UpdateAlbumRequest;
use App\Models\GalleryAlbum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class GalleryAlbumController extends Controller
{
    public function index(): Response
    {
        $albums = GalleryAlbum::withCount('photos')
            ->orderByDesc('created_at')
            ->paginate(15);

        return Inertia::render('admin/gallery/Index', [
            'albums' => $albums,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/gallery/Create');
    }

    public function store(StoreAlbumRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('gallery/covers', 'public');
        }

        GalleryAlbum::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Album created successfully.');
    }

    public function edit(GalleryAlbum $album): Response
    {
        $album->load(['photos' => fn ($q) => $q->orderBy('sort_order')]);

        return Inertia::render('admin/gallery/Edit', [
            'album' => $album,
        ]);
    }

    public function update(UpdateAlbumRequest $request, GalleryAlbum $album): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('gallery/covers', 'public');
        } else {
            unset($data['cover_image']);
        }

        $album->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Album updated successfully.');
    }

    public function destroy(GalleryAlbum $album): RedirectResponse
    {
        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
        }
        foreach ($album->photos as $photo) {
            Storage::disk('public')->delete($photo->image_path);
        }

        $album->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Album deleted successfully.');
    }
}

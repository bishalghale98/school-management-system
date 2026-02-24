<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GalleryPhotoController extends Controller
{
    public function store(Request $request, GalleryAlbum $album): RedirectResponse
    {
        $request->validate([
            'photos' => ['required', 'array'],
            'photos.*' => ['image', 'max:5120'],
        ]);

        $maxSort = $album->photos()->max('sort_order') ?? 0;

        foreach ($request->file('photos') as $photo) {
            $album->photos()->create([
                'image_path' => $photo->store('gallery/photos', 'public'),
                'sort_order' => ++$maxSort,
            ]);
        }

        return back()->with('success', 'Photos uploaded successfully.');
    }

    public function update(Request $request, GalleryPhoto $photo): RedirectResponse
    {
        $request->validate([
            'caption' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $photo->update($request->only(['caption', 'sort_order']));

        return back()->with('success', 'Photo updated.');
    }

    public function reorder(Request $request, GalleryAlbum $album): RedirectResponse
    {
        $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:gallery_photos,id'],
        ]);

        foreach ($request->input('order') as $index => $photoId) {
            GalleryPhoto::where('id', $photoId)->update(['sort_order' => $index]);
        }

        return back()->with('success', 'Photos reordered.');
    }

    public function destroy(GalleryPhoto $photo): RedirectResponse
    {
        Storage::disk('public')->delete($photo->image_path);
        $photo->delete();

        return back()->with('success', 'Photo deleted.');
    }
}

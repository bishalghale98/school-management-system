<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDownloadRequest;
use App\Http\Requests\Admin\UpdateDownloadRequest;
use App\Models\Download;
use App\Models\DownloadCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DownloadController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Download::with('category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $downloads = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $categories = DownloadCategory::all();

        return Inertia::render('admin/downloads/Index', [
            'downloads' => $downloads,
            'categories' => $categories,
            'filters' => $request->only(['category', 'status']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/downloads/Create', [
            'categories' => DownloadCategory::all(),
        ]);
    }

    public function store(StoreDownloadRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('downloads', 'public');
        }
        unset($data['file']);

        Download::create($data);

        return redirect()->route('admin.downloads.index')->with('success', 'Download created successfully.');
    }

    public function edit(Download $download): Response
    {
        return Inertia::render('admin/downloads/Edit', [
            'download' => $download,
            'categories' => DownloadCategory::all(),
        ]);
    }

    public function update(UpdateDownloadRequest $request, Download $download): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('file')) {
            if ($download->file_path) {
                Storage::disk('public')->delete($download->file_path);
            }
            $data['file_path'] = $request->file('file')->store('downloads', 'public');
        }
        unset($data['file']);

        $download->update($data);

        return redirect()->route('admin.downloads.index')->with('success', 'Download updated successfully.');
    }

    public function destroy(Download $download): RedirectResponse
    {
        if ($download->file_path) {
            Storage::disk('public')->delete($download->file_path);
        }

        $download->delete();

        return redirect()->route('admin.downloads.index')->with('success', 'Download deleted successfully.');
    }
}

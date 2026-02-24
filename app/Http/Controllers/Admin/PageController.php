<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePageRequest;
use App\Http\Requests\Admin\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function index(): Response
    {
        $pages = Page::orderBy('sort_order')
            ->orderByDesc('updated_at')
            ->paginate(15);

        return Inertia::render('admin/pages/Index', [
            'pages' => $pages,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/pages/Create');
    }

    public function store(StorePageRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('pages/og', 'public');
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page): Response
    {
        return Inertia::render('admin/pages/Edit', [
            'page' => $page,
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        }
        if ($request->hasFile('og_image')) {
            $data['og_image'] = $request->file('og_image')->store('pages/og', 'public');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}

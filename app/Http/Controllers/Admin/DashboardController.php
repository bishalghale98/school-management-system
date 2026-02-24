<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\ContactMessage;
use App\Models\Download;
use App\Models\GalleryAlbum;
use App\Models\Page;
use App\Models\Post;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('admin/Dashboard', [
            'stats' => [
                'pages' => Page::count(),
                'posts' => Post::count(),
                'albums' => GalleryAlbum::count(),
                'downloads' => Download::count(),
                'pendingAdmissions' => AdmissionApplication::pending()->count(),
                'unreadMessages' => ContactMessage::unread()->count(),
            ],
            'recentPosts' => Post::with('category')->latest()->limit(5)->get(),
            'recentApplications' => AdmissionApplication::latest()->limit(5)->get(),
            'recentMessages' => ContactMessage::latest()->limit(5)->get(),
        ]);
    }
}

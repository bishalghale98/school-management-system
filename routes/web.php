<?php

use App\Http\Controllers\PublicSite\AdmissionController;
use App\Http\Controllers\PublicSite\ContactController;
use App\Http\Controllers\PublicSite\DownloadController;
use App\Http\Controllers\PublicSite\GalleryController;
use App\Http\Controllers\PublicSite\HomeController;
use App\Http\Controllers\PublicSite\PageController;
use App\Http\Controllers\PublicSite\PostController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth dashboard (keep existing)
Route::get('dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// News / Notices
Route::get('news-update', [PostController::class, 'index'])->name('posts.index');
Route::get('news-update/{slug}', [PostController::class, 'show'])->name('posts.show');

// Downloads
Route::get('downloads', [DownloadController::class, 'index'])->name('downloads.index');

// Gallery
Route::get('gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

// Admission
Route::get('admission', [AdmissionController::class, 'show'])->name('admission.show');
Route::post('admission', [AdmissionController::class, 'store'])->name('admission.store')->middleware('throttle:5,1');

// Contact
Route::get('contact-us', [ContactController::class, 'show'])->name('contact.show');
Route::post('contact-us', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:5,1');

// Dynamic pages (must be last — catches /{slug})
Route::get('{slug}', [PageController::class, 'show'])->name('pages.show')->where('slug', '(?!login|register|logout|forgot-password|reset-password|email|user|admin|settings|dashboard|sanctum|_boost)[a-z0-9\-]+');

require __DIR__.'/settings.php';

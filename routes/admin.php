<?php

use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\GalleryPhotoController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Uploads (for rich text editor)
Route::post('upload/image', [UploadController::class, 'image'])->name('upload.image');

// Pages
Route::resource('pages', PageController::class)->except(['show']);

// Posts
Route::resource('posts', PostController::class)->except(['show']);
Route::delete('posts/{post}/attachments/{attachment}', [PostController::class, 'deleteAttachment'])->name('posts.attachments.destroy');

// Downloads
Route::resource('downloads', DownloadController::class)->except(['show']);

// Gallery
Route::resource('gallery', GalleryAlbumController::class)->except(['show'])->parameters(['gallery' => 'album']);
Route::post('gallery/{album}/photos', [GalleryPhotoController::class, 'store'])->name('gallery.photos.store');
Route::put('gallery/{album}/photos/reorder', [GalleryPhotoController::class, 'reorder'])->name('gallery.photos.reorder');
Route::put('photos/{photo}', [GalleryPhotoController::class, 'update'])->name('photos.update');
Route::delete('photos/{photo}', [GalleryPhotoController::class, 'destroy'])->name('photos.destroy');

// Admissions
Route::get('admissions', [AdmissionController::class, 'index'])->name('admissions.index');
Route::get('admissions/{application}', [AdmissionController::class, 'show'])->name('admissions.show');
Route::put('admissions/{application}/status', [AdmissionController::class, 'updateStatus'])->name('admissions.updateStatus');
Route::post('admissions/toggle', [AdmissionController::class, 'toggleAdmission'])->name('admissions.toggle');
Route::put('admissions/settings', [AdmissionController::class, 'updateSettings'])->name('admissions.settings');

// Contact Messages
Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

// Settings
Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

// Users (super admin only)
Route::resource('users', UserController::class)->except(['show']);

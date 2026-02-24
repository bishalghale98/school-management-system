<?php

namespace App\Console\Commands;

use App\Models\Download;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Models\SiteSetting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupStorage extends Command
{
    protected $signature = 'storage:cleanup {--dry-run : Show what would be deleted without actually deleting}';

    protected $description = 'Delete orphaned files from storage that are not referenced in the database';

    public function handle(): int
    {
        $disk = Storage::disk('public');
        $totalDeleted = 0;

        // Define directories and how to find referenced files
        $checks = [
            [
                'directory' => 'posts',
                'label' => 'Post featured images',
                'referenced' => fn () => Post::whereNotNull('featured_image')->pluck('featured_image')->toArray(),
            ],
            [
                'directory' => 'posts/og',
                'label' => 'Post OG images',
                'referenced' => fn () => Post::whereNotNull('og_image')->pluck('og_image')->toArray(),
            ],
            [
                'directory' => 'posts/attachments',
                'label' => 'Post attachments',
                'referenced' => fn () => PostAttachment::pluck('file_path')->toArray(),
            ],
            [
                'directory' => 'pages',
                'label' => 'Page featured images',
                'referenced' => fn () => Page::whereNotNull('featured_image')->pluck('featured_image')->toArray(),
            ],
            [
                'directory' => 'pages/og',
                'label' => 'Page OG images',
                'referenced' => fn () => Page::whereNotNull('og_image')->pluck('og_image')->toArray(),
            ],
            [
                'directory' => 'downloads',
                'label' => 'Download files',
                'referenced' => fn () => Download::whereNotNull('file_path')->pluck('file_path')->toArray(),
            ],
            [
                'directory' => 'gallery/covers',
                'label' => 'Gallery album covers',
                'referenced' => fn () => GalleryAlbum::whereNotNull('cover_image')->pluck('cover_image')->toArray(),
            ],
            [
                'directory' => 'gallery/photos',
                'label' => 'Gallery photos',
                'referenced' => fn () => GalleryPhoto::pluck('image_path')->toArray(),
            ],
            [
                'directory' => 'settings',
                'label' => 'Settings assets',
                'referenced' => function () {
                    $settings = SiteSetting::first();

                    return $settings && $settings->logo ? [$settings->logo] : [];
                },
            ],
            [
                'directory' => 'uploads/editor',
                'label' => 'Editor inline images',
                'referenced' => function () {
                    $paths = collect();

                    Post::whereNotNull('content')->pluck('content')->each(function ($content) use (&$paths) {
                        if (preg_match_all('/\/storage\/(uploads\/editor\/[^"\'\s]+)/', $content, $matches)) {
                            $paths = $paths->merge($matches[1]);
                        }
                    });

                    Page::whereNotNull('content')->pluck('content')->each(function ($content) use (&$paths) {
                        if (preg_match_all('/\/storage\/(uploads\/editor\/[^"\'\s]+)/', $content, $matches)) {
                            $paths = $paths->merge($matches[1]);
                        }
                    });

                    return $paths->unique()->toArray();
                },
            ],
            [
                'directory' => 'uploads',
                'label' => 'Stray uploads (root)',
                'referenced' => fn () => [], // files directly in uploads/ are never referenced
            ],
            [
                'directory' => 'admissions/documents',
                'label' => 'Admission documents',
                'referenced' => function () {
                    $paths = collect();

                    \App\Models\AdmissionApplication::whereNotNull('documents')->pluck('documents')->each(function ($docs) use (&$paths) {
                        if (is_array($docs)) {
                            $paths = $paths->merge($docs);
                        }
                    });

                    return $paths->toArray();
                },
            ],
        ];

        foreach ($checks as $check) {
            $allFiles = $disk->files($check['directory']);

            if (empty($allFiles)) {
                continue;
            }

            $referenced = ($check['referenced'])();
            $orphaned = array_diff($allFiles, $referenced);

            if (empty($orphaned)) {
                continue;
            }

            $this->info(count($orphaned)." orphaned {$check['label']}:");

            foreach ($orphaned as $file) {
                $this->line("  - {$file}");
            }

            if (! $this->option('dry-run')) {
                foreach ($orphaned as $file) {
                    $disk->delete($file);
                }
            }

            $totalDeleted += count($orphaned);
        }

        if ($totalDeleted === 0) {
            $this->info('No orphaned files found. Storage is clean!');
        } elseif ($this->option('dry-run')) {
            $this->warn("\n{$totalDeleted} total orphaned file(s) found. Dry run — no files were deleted.");
        } else {
            $this->info("\n{$totalDeleted} total orphaned file(s) deleted.");
        }

        return self::SUCCESS;
    }
}

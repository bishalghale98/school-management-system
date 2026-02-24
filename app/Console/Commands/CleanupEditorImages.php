<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupEditorImages extends Command
{
    protected $signature = 'editor:cleanup {--dry-run : Show what would be deleted without actually deleting}';

    protected $description = 'Delete orphaned editor images not referenced by any post or page';

    public function handle(): int
    {
        $disk = Storage::disk('public');

        // Get all files in uploads/editor directory
        $allFiles = $disk->files('uploads/editor');

        if (empty($allFiles)) {
            $this->info('No editor images found.');

            return self::SUCCESS;
        }

        // Collect all referenced editor image paths from posts and pages
        $referencedPaths = collect();

        Post::whereNotNull('content')->pluck('content')->each(function ($content) use (&$referencedPaths) {
            if (preg_match_all('/\/storage\/(uploads\/editor\/[^"\'\s]+)/', $content, $matches)) {
                $referencedPaths = $referencedPaths->merge($matches[1]);
            }
        });

        Page::whereNotNull('content')->pluck('content')->each(function ($content) use (&$referencedPaths) {
            if (preg_match_all('/\/storage\/(uploads\/editor\/[^"\'\s]+)/', $content, $matches)) {
                $referencedPaths = $referencedPaths->merge($matches[1]);
            }
        });

        $referencedPaths = $referencedPaths->unique()->toArray();

        // Find orphaned files
        $orphaned = array_diff($allFiles, $referencedPaths);

        if (empty($orphaned)) {
            $this->info('No orphaned editor images found.');

            return self::SUCCESS;
        }

        $this->info(count($orphaned).' orphaned editor image(s) found:');

        foreach ($orphaned as $file) {
            $this->line("  - {$file}");
        }

        if ($this->option('dry-run')) {
            $this->warn('Dry run — no files were deleted.');

            return self::SUCCESS;
        }

        foreach ($orphaned as $file) {
            $disk->delete($file);
        }

        $this->info(count($orphaned).' orphaned image(s) deleted.');

        return self::SUCCESS;
    }
}

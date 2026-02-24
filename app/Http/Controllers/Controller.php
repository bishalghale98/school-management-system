<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    use AuthorizesRequests;

    /**
     * Extract editor image paths from HTML content.
     *
     * @return string[]
     */
    protected function extractEditorImages(?string $content): array
    {
        if (! $content) {
            return [];
        }

        if (preg_match_all('/\/storage\/(uploads\/editor\/[^"\'\s]+)/', $content, $matches)) {
            return $matches[1];
        }

        return [];
    }

    /**
     * Delete all editor images embedded in HTML content.
     */
    protected function deleteEditorImages(?string $content): void
    {
        foreach ($this->extractEditorImages($content) as $path) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Compare old and new content, delete editor images that were removed.
     */
    protected function cleanupRemovedEditorImages(?string $oldContent, ?string $newContent): void
    {
        $oldImages = $this->extractEditorImages($oldContent);
        $newImages = $this->extractEditorImages($newContent);

        $removedImages = array_diff($oldImages, $newImages);

        foreach ($removedImages as $path) {
            Storage::disk('public')->delete($path);
        }
    }
}

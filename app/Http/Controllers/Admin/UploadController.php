<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function image(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:5120'],
        ]);

        $path = $request->file('image')->store('uploads/editor', 'public');

        return response()->json([
            'url' => '/storage/' . $path,
        ]);
    }
}

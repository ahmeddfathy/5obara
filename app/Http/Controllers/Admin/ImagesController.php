<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImagesController extends Controller
{
    /**
     * Upload an image for CKEditor 5
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ckeditorUpload(Request $request)
    {
        if (!$request->hasFile('upload')) {
            return response()->json([
                'error' => [
                    'message' => 'No file uploaded'
                ]
            ], 400);
        }

        try {
            $file = $request->file('upload');

            // التحقق من نوع الملف
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
                return response()->json([
                    'error' => [
                        'message' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP images are allowed.'
                    ]
                ], 400);
            }

            // تخزين الملف
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('posts/content', $fileName, 'public');

            return response()->json([
                'url' => asset('storage/' . $path)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => 'Error uploading file: ' . $e->getMessage()
                ]
            ], 500);
        }
    }

    /**
     * Upload an image for general use
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json([
                'error' => [
                    'message' => 'No file uploaded'
                ]
            ], 400);
        }

        try {
            $file = $request->file('file');

            // التحقق من نوع الملف
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
                return response()->json([
                    'error' => [
                        'message' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP images are allowed.'
                    ]
                ], 400);
            }

            // تخزين الملف
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('posts/content', $fileName, 'public');

            return response()->json([
                'location' => asset('storage/' . $path)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => 'Error uploading file: ' . $e->getMessage()
                ]
            ], 500);
        }
    }
}

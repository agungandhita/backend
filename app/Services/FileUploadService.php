<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileUploadService
{
    /**
     * Upload image file
     */
    public function uploadImage(UploadedFile $file, string $disk, string $directory = null): string
    {
        $filename = $this->generateFilename($file);
        $path = $directory ? $directory . '/' . $filename : $filename;
        
        // Optimize image before storing
        $optimizedImage = $this->optimizeImage($file);
        
        Storage::disk($disk)->put($path, $optimizedImage);
        
        return $path;
    }

    /**
     * Upload PDF file
     */
    public function uploadPdf(UploadedFile $file, string $disk, string $directory = null): string
    {
        $filename = $this->generateFilename($file);
        $path = $directory ? $directory . '/' . $filename : $filename;
        
        Storage::disk($disk)->putFileAs($directory ?: '', $file, $filename);
        
        return $path;
    }

    /**
     * Delete file
     */
    public function deleteFile(string $path, string $disk): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }
        
        return false;
    }

    /**
     * Optimize image (resize & compress)
     */
    public function optimizeImage(UploadedFile $file): string
    {
        $image = Image::make($file->getRealPath());
        
        // Resize if image is too large
        if ($image->width() > 1200 || $image->height() > 1200) {
            $image->resize(1200, 1200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        
        // Compress image
        return $image->encode('jpg', 85)->__toString();
    }

    /**
     * Generate unique filename
     */
    private function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '.' . $extension;
        
        return $filename;
    }

    /**
     * Get file URL
     */
    public function getFileUrl(string $path, string $disk): string
    {
        return Storage::disk($disk)->url($path);
    }

    /**
     * Validate image file
     */
    public function validateImage(UploadedFile $file): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        return in_array($file->getMimeType(), $allowedMimes) && $file->getSize() <= $maxSize;
    }

    /**
     * Validate PDF file
     */
    public function validatePdf(UploadedFile $file): bool
    {
        $allowedMimes = ['application/pdf'];
        $maxSize = 10 * 1024 * 1024; // 10MB
        
        return in_array($file->getMimeType(), $allowedMimes) && $file->getSize() <= $maxSize;
    }
}
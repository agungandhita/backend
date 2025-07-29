<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * Generate dynamic URL for storage files
     *
     * @param string|null $filePath
     * @param string $folder
     * @return string|null
     */
    public static function getStorageUrl(?string $filePath, string $folder = ''): ?string
    {
        if (!$filePath) {
            return null;
        }

        $baseUrl = rtrim(config('app.url'), '/');
        $storagePath = $folder ? "storage/{$folder}/{$filePath}" : "storage/{$filePath}";

        return "{$baseUrl}/{$storagePath}";
    }

    /**
     * Generate URL for tool images
     *
     * @param string|null $imageName
     * @return string|null
     */
    public static function getToolImageUrl(?string $imageName): ?string
    {
        return self::getStorageUrl($imageName, 'alat');
    }

    /**
     * Generate URL for PDF files
     *
     * @param string|null $pdfName
     * @return string|null
     */
    public static function getPdfUrl(?string $pdfName): ?string
    {
        return self::getStorageUrl($pdfName, 'pdfs');
    }

    /**
     * Check if file exists in storage
     *
     * @param string|null $filePath
     * @param string $folder
     * @return bool
     */
    public static function fileExists(?string $filePath, string $folder = ''): bool
    {
        if (!$filePath) {
            return false;
        }

        $fullPath = $folder ? "public/{$folder}/{$filePath}" : "public/{$filePath}";
        return Storage::disk('local')->exists($fullPath);
    }

    /**
     * Get file size in human readable format
     *
     * @param string|null $filePath
     * @param string $folder
     * @return string|null
     */
    public static function getFileSize(?string $filePath, string $folder = ''): ?string
    {
        if (!$filePath || !self::fileExists($filePath, $folder)) {
            return null;
        }

        $fullPath = $folder ? "public/{$folder}/{$filePath}" : "public/{$filePath}";
        $bytes = Storage::disk('local')->size($fullPath);

        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Check if tool image exists
     *
     * @param string|null $imageName
     * @return bool
     */
    public static function toolImageExists(?string $imageName): bool
    {
        return self::fileExists($imageName, 'alat');
    }

    /**
     * Check if PDF file exists
     *
     * @param string|null $pdfName
     * @return bool
     */
    public static function pdfExists(?string $pdfName): bool
    {
        return self::fileExists($pdfName, 'pdfs');
    }

    /**
     * Get tool image file size
     *
     * @param string|null $imageName
     * @return string|null
     */
    public static function getToolImageSize(?string $imageName): ?string
    {
        return self::getFileSize($imageName, 'alat');
    }

    /**
     * Get PDF file size
     *
     * @param string|null $pdfName
     * @return string|null
     */
    public static function getPdfSize(?string $pdfName): ?string
    {
        return self::getFileSize($pdfName, 'pdfs');
    }
}

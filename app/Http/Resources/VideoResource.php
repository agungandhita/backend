<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'youtube_url' => $this->youtube_url,
            'youtube_id' => $this->getYoutubeId(),
            'thumbnail' => $this->getThumbnail(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Extract YouTube video ID from URL
     */
    private function getYoutubeId()
    {
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $this->youtube_url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    /**
     * Get YouTube thumbnail URL
     */
    private function getThumbnail()
    {
        $youtubeId = $this->getYoutubeId();
        return $youtubeId ? "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg" : null;
    }
}
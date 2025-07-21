<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToolResource extends JsonResource
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
            'nama' => $this->nama,
            'gambar' => $this->gambar ? asset('storage/tools/' . $this->gambar) : null,
            'deskripsi' => $this->deskripsi,
            'fungsi' => $this->fungsi,
            'url_video' => $this->url_video,
            'file_pdf' => $this->file_pdf ? asset('storage/pdfs/' . $this->file_pdf) : null,
            'kategori' => $this->kategori,
            'views_count' => $this->views_count,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'tags' => $this->tags,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'is_favorited' => $this->when(
                auth()->check(),
                function () {
                    return $this->favoritedBy->contains(auth()->id());
                },
                false
            ),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
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
            'gambar' => $this->gambar ? asset('storage/' . $this->gambar) : null,
            'deskripsi' => $this->deskripsi,
            'fungsi' => $this->fungsi,
            'url_video' => $this->url_video,
            'file_pdf' => $this->file_pdf ? asset('storage/' . $this->file_pdf) : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
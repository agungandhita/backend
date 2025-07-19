<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'kelas' => $this->kelas,
            'foto' => $this->foto ? asset('storage/' . $this->foto) : null,
            'progress' => $this->progress,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
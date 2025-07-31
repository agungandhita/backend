<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class ScoreResource extends JsonResource
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
            'skor' => $this->skor,
            'total_soal' => $this->total_soal,
            'benar' => $this->benar,
            'salah' => $this->salah,
            'level' => $this->level,
            'persentase' => $this->total_soal > 0 ? round(($this->benar / $this->total_soal) * 100, 2) : 0,
            'tanggal' => $this->tanggal->format('Y-m-d H:i:s'),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
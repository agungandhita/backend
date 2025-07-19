<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
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
            'soal' => $this->soal,
            'pilihan' => [
                'a' => $this->pilihan_a,
                'b' => $this->pilihan_b,
                'c' => $this->pilihan_c,
                'd' => $this->pilihan_d,
            ],
            'level' => $this->level,
            // Jawaban benar tidak disertakan untuk keamanan
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
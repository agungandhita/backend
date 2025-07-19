<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Video;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'judul' => 'Pengenalan Alat-Alat Teknik Dasar',
                'deskripsi' => 'Video pembelajaran yang memperkenalkan berbagai alat teknik dasar yang sering digunakan dalam pekerjaan teknik mesin dan listrik. Cocok untuk pemula yang ingin mempelajari fungsi dan cara penggunaan alat-alat dasar.',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Cara Menggunakan Tang dan Obeng dengan Benar',
                'deskripsi' => 'Tutorial lengkap tentang cara menggunakan tang dan obeng dengan benar dan aman. Termasuk tips keselamatan kerja dan teknik yang efisien.',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Perawatan dan Penyimpanan Alat Teknik',
                'deskripsi' => 'Video yang menjelaskan cara merawat dan menyimpan alat-alat teknik agar tetap awet dan berfungsi dengan baik. Termasuk tips pembersihan dan pelumasan.',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($videos as $video) {
            Video::create($video);
        }
    }
}

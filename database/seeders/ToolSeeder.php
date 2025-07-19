<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tool;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tools = [
            [
                'nama' => 'Tang Kombinasi',
                'gambar' => null,
                'deskripsi' => 'Tang kombinasi adalah alat yang memiliki fungsi ganda yaitu untuk mencengkeram dan memotong kawat. Bagian rahang tang berbentuk datar dengan permukaan bergerigi untuk mencengkeram benda kerja.',
                'fungsi' => 'Digunakan untuk mencengkeram, memutar, dan memotong kawat atau kabel. Sangat berguna dalam pekerjaan listrik dan mekanik.',
                'url_video' => 'https://www.youtube.com/watch?v=example1',
                'file_pdf' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Obeng Plus',
                'gambar' => null,
                'deskripsi' => 'Obeng plus atau obeng Phillips adalah alat untuk mengencangkan atau mengendurkan sekrup dengan kepala berbentuk plus (+). Ujung obeng berbentuk silang yang pas dengan alur sekrup.',
                'fungsi' => 'Digunakan untuk mengencangkan dan mengendurkan sekrup berkepala plus. Umum digunakan dalam perakitan elektronik dan furniture.',
                'url_video' => 'https://www.youtube.com/watch?v=example2',
                'file_pdf' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kunci Pas',
                'gambar' => null,
                'deskripsi' => 'Kunci pas adalah alat untuk mengencangkan atau mengendurkan mur dan baut. Memiliki dua ujung dengan bukaan yang berbeda ukuran, biasanya berukuran milimeter.',
                'fungsi' => 'Digunakan untuk mengencangkan dan mengendurkan mur serta baut dengan berbagai ukuran. Essential tool dalam pekerjaan mekanik.',
                'url_video' => 'https://www.youtube.com/watch?v=example3',
                'file_pdf' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Multimeter Digital',
                'gambar' => null,
                'deskripsi' => 'Multimeter digital adalah alat ukur listrik yang dapat mengukur tegangan (voltage), arus (ampere), dan hambatan (resistance). Dilengkapi dengan display digital untuk pembacaan yang akurat.',
                'fungsi' => 'Digunakan untuk mengukur tegangan AC/DC, arus listrik, hambatan, dan kontinuitas rangkaian. Essential tool untuk teknisi listrik dan elektronik.',
                'url_video' => 'https://www.youtube.com/watch?v=example4',
                'file_pdf' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Solder Listrik',
                'gambar' => null,
                'deskripsi' => 'Solder listrik adalah alat untuk menyambung komponen elektronik dengan cara melelehkan timah solder. Memiliki mata solder yang dapat dipanaskan dengan listrik.',
                'fungsi' => 'Digunakan untuk menyolder komponen elektronik, memperbaiki rangkaian PCB, dan pekerjaan elektronik lainnya yang membutuhkan penyambungan presisi.',
                'url_video' => 'https://www.youtube.com/watch?v=example5',
                'file_pdf' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Crimping Tool',
                'gambar' => null,
                'deskripsi' => 'Crimping tool adalah alat untuk memasang konektor pada kabel jaringan seperti RJ45, RJ11. Memiliki pisau pemotong dan penjepit konektor yang presisi.',
                'fungsi' => 'Digunakan untuk membuat kabel jaringan (UTP/STP), memasang konektor RJ45/RJ11, dan pekerjaan instalasi jaringan komputer.',
                'url_video' => 'https://www.youtube.com/watch?v=example6',
                'file_pdf' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($tools as $tool) {
            Tool::create($tool);
        }
    }
}

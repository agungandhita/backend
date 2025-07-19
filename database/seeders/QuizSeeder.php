<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quiz;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quizzes = [
            // Level Mudah
            [
                'soal' => 'Apa fungsi utama dari tang kombinasi?',
                'pilihan_a' => 'Hanya untuk memotong kawat',
                'pilihan_b' => 'Mencengkeram dan memotong kawat',
                'pilihan_c' => 'Hanya untuk mencengkeram',
                'pilihan_d' => 'Mengukur diameter kawat',
                'jawaban_benar' => 'b',
                'level' => 'mudah',
            ],
            [
                'soal' => 'Obeng dengan ujung berbentuk plus (+) disebut?',
                'pilihan_a' => 'Obeng minus',
                'pilihan_b' => 'Obeng Phillips',
                'pilihan_c' => 'Obeng pipih',
                'pilihan_d' => 'Obeng bintang',
                'jawaban_benar' => 'b',
                'level' => 'mudah',
            ],
            [
                'soal' => 'Alat yang digunakan untuk mengencangkan mur dan baut adalah?',
                'pilihan_a' => 'Tang',
                'pilihan_b' => 'Obeng',
                'pilihan_c' => 'Kunci pas',
                'pilihan_d' => 'Gergaji',
                'jawaban_benar' => 'c',
                'level' => 'mudah',
            ],
            [
                'soal' => 'Warna yang umum digunakan untuk pegangan alat isolasi listrik adalah?',
                'pilihan_a' => 'Hitam',
                'pilihan_b' => 'Merah atau kuning',
                'pilihan_c' => 'Biru',
                'pilihan_d' => 'Hijau',
                'jawaban_benar' => 'b',
                'level' => 'mudah',
            ],
            [
                'soal' => 'Sebelum menggunakan alat listrik, hal pertama yang harus diperiksa adalah?',
                'pilihan_a' => 'Harga alat',
                'pilihan_b' => 'Warna alat',
                'pilihan_c' => 'Kondisi kabel dan isolasi',
                'pilihan_d' => 'Berat alat',
                'jawaban_benar' => 'c',
                'level' => 'mudah',
            ],

            // Level Sedang
            [
                'soal' => 'Berapa tegangan maksimum yang aman untuk alat dengan isolasi standar?',
                'pilihan_a' => '220V',
                'pilihan_b' => '380V',
                'pilihan_c' => '1000V',
                'pilihan_d' => '1500V',
                'jawaban_benar' => 'c',
                'level' => 'sedang',
            ],
            [
                'soal' => 'Pada kunci pas, angka yang tertera menunjukkan?',
                'pilihan_a' => 'Panjang kunci',
                'pilihan_b' => 'Berat kunci',
                'pilihan_c' => 'Lebar bukaan rahang',
                'pilihan_d' => 'Kekuatan maksimum',
                'jawaban_benar' => 'c',
                'level' => 'sedang',
            ],
            [
                'soal' => 'Material yang paling baik untuk mata obeng berkualitas tinggi adalah?',
                'pilihan_a' => 'Aluminium',
                'pilihan_b' => 'Baja karbon tinggi',
                'pilihan_c' => 'Plastik',
                'pilihan_d' => 'Kuningan',
                'jawaban_benar' => 'b',
                'level' => 'sedang',
            ],
            [
                'soal' => 'Torsi yang berlebihan pada sekrup dapat menyebabkan?',
                'pilihan_a' => 'Sekrup lebih kuat',
                'pilihan_b' => 'Sekrup rusak atau ulir rusak',
                'pilihan_c' => 'Sekrup lebih mudah dibuka',
                'pilihan_d' => 'Tidak ada efek',
                'jawaban_benar' => 'b',
                'level' => 'sedang',
            ],
            [
                'soal' => 'Frekuensi perawatan rutin untuk alat-alat teknik sebaiknya?',
                'pilihan_a' => 'Setiap hari',
                'pilihan_b' => 'Setiap minggu',
                'pilihan_c' => 'Setiap bulan',
                'pilihan_d' => 'Setiap tahun',
                'jawaban_benar' => 'c',
                'level' => 'sedang',
            ],

            // Level Sulit
            [
                'soal' => 'Standar internasional untuk alat isolasi listrik adalah?',
                'pilihan_a' => 'ISO 9001',
                'pilihan_b' => 'IEC 60900',
                'pilihan_c' => 'ANSI Z87',
                'pilihan_d' => 'DIN 5510',
                'jawaban_benar' => 'b',
                'level' => 'sulit',
            ],
            [
                'soal' => 'Pada tang, sudut optimal untuk rahang cengkeram adalah?',
                'pilihan_a' => '30 derajat',
                'pilihan_b' => '45 derajat',
                'pilihan_c' => '60 derajat',
                'pilihan_d' => '90 derajat',
                'jawaban_benar' => 'c',
                'level' => 'sulit',
            ],
            [
                'soal' => 'Heat treatment yang tepat untuk alat potong baja adalah?',
                'pilihan_a' => 'Annealing saja',
                'pilihan_b' => 'Quenching dan tempering',
                'pilihan_c' => 'Normalizing saja',
                'pilihan_d' => 'Stress relieving',
                'jawaban_benar' => 'b',
                'level' => 'sulit',
            ],
            [
                'soal' => 'Koefisien gesek optimal untuk pegangan alat adalah?',
                'pilihan_a' => '0.2 - 0.4',
                'pilihan_b' => '0.4 - 0.6',
                'pilihan_c' => '0.6 - 0.8',
                'pilihan_d' => '0.8 - 1.0',
                'jawaban_benar' => 'c',
                'level' => 'sulit',
            ],
            [
                'soal' => 'Dalam desain ergonomis alat, sudut optimal untuk pegangan adalah?',
                'pilihan_a' => '15-20 derajat',
                'pilihan_b' => '20-25 derajat',
                'pilihan_c' => '25-30 derajat',
                'pilihan_d' => '30-35 derajat',
                'jawaban_benar' => 'a',
                'level' => 'sulit',
            ],
        ];

        foreach ($quizzes as $quiz) {
            Quiz::create(array_merge($quiz, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Score;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin SMK',
            'email' => 'admin@smk.com',
            'password' => Hash::make('password123'),
            'kelas' => null,
            'foto' => null,
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create dummy students
        $user1 = User::create([
            'name' => 'Ahmad Siswa',
            'email' => 'ahmad@smk.com',
            'password' => Hash::make('password123'),
            'kelas' => 'XII TKJ 1',
            'foto' => null,
            'role' => 'siswa',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user2 = User::create([
            'name' => 'Sari Dewi',
            'email' => 'sari@smk.com',
            'password' => Hash::make('password123'),
            'kelas' => 'XI TKJ 2',
            'foto' => null,
            'role' => 'siswa',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user3 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@smk.com',
            'password' => Hash::make('password123'),
            'kelas' => 'X TKJ 1',
            'foto' => null,
            'role' => 'siswa',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create some dummy scores for the users
        $scores = [
            [
                'user_id' => $user1->id,
                'skor' => 80,
                'total_soal' => 5,
                'benar' => 4,
                'salah' => 1,
                'level' => 'mudah',
                'tanggal' => now()->subDays(5),
            ],
            [
                'user_id' => $user1->id,
                'skor' => 60,
                'total_soal' => 5,
                'benar' => 3,
                'salah' => 2,
                'level' => 'sedang',
                'tanggal' => now()->subDays(3),
            ],
            [
                'user_id' => $user1->id,
                'skor' => 40,
                'total_soal' => 5,
                'benar' => 2,
                'salah' => 3,
                'level' => 'sulit',
                'tanggal' => now()->subDays(1),
            ],
            [
                'user_id' => $user2->id,
                'skor' => 90,
                'total_soal' => 5,
                'benar' => 4,
                'salah' => 1,
                'level' => 'mudah',
                'tanggal' => now()->subDays(2),
            ],
            [
                'user_id' => $user2->id,
                'skor' => 70,
                'total_soal' => 5,
                'benar' => 3,
                'salah' => 2,
                'level' => 'sedang',
                'tanggal' => now()->subDays(1),
            ],
            [
                'user_id' => $user3->id,
                'skor' => 85,
                'total_soal' => 5,
                'benar' => 4,
                'salah' => 1,
                'level' => 'mudah',
                'tanggal' => now(),
            ],
        ];

        foreach ($scores as $score) {
            Score::create(array_merge($score, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }


    }
}

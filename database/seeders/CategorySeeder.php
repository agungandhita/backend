<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Pengukuran',
                'deskripsi' => 'Alat-alat untuk mengukur berbagai besaran fisik',
                'icon' => 'ruler-icon'
            ],
            [
                'nama' => 'Pemotong',
                'deskripsi' => 'Alat-alat untuk memotong berbagai material',
                'icon' => 'cut-icon'
            ],
            [
                'nama' => 'Pengeboran',
                'deskripsi' => 'Alat-alat untuk membuat lubang pada material',
                'icon' => 'drill-icon'
            ],
            [
                'nama' => 'Pengencang',
                'deskripsi' => 'Alat-alat untuk mengencangkan atau melonggarkan baut dan sekrup',
                'icon' => 'wrench-icon'
            ],
            [
                'nama' => 'Keselamatan',
                'deskripsi' => 'Alat pelindung diri untuk keselamatan kerja',
                'icon' => 'safety-icon'
            ],
            [
                'nama' => 'Elektronik',
                'deskripsi' => 'Alat-alat untuk pekerjaan elektronik dan kelistrikan',
                'icon' => 'electronic-icon'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
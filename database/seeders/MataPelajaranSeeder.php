<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =
            [
                [ // 1
                    'nama' => 'Pendidikan Agama Islam',
                    'kelompok' => 'A',
                ],
                [ // 2
                    'nama' => 'Pendidikan Kewarganegaraan',
                    'kelompok' => 'A',
                ],
                [ // 3
                    'nama' => 'Bahasa Indonesia',
                    'kelompok' => 'A',
                ],
                [ // 4
                    'nama' => 'Matematika',
                    'kelompok' => 'A',
                ],
                [ // 5
                    'nama' => 'Ilmu Pengetahuan Alam',
                    'kelompok' => 'A',
                ],
                [ // 6
                    'nama' => 'Ilmu Pengetahuan Sosial',
                    'kelompok' => 'A',
                ],
                [ // 7
                    'nama' => 'Bahasa Inggris',
                    'kelompok' => 'A',
                ],
                [ // 8
                    'nama' => 'Bahasa Jawa',
                    'kelompok' => 'B',
                ],
                [ // 9
                    'nama' => 'Seni Budaya',
                    'kelompok' => 'B',
                ],
                [ // 10
                    'nama' => 'Pendidikan Jasmani, Olahraga dan Kesehatan',
                    'kelompok' => 'B',
                ],
                [ // 11
                    'nama' => 'Informatika',
                    'kelompok' => 'B',
                ],
                [ // 12
                    'nama' => 'TIK',
                    'kelompok' => 'B',
                ],
                [ // 13
                    'nama' => 'Prakarya',
                    'kelompok' => 'B',
                ],
                [ // 14
                    'nama' => "Akhlak",
                    'kelompok' => 'C',
                ],
                [ // 15
                    'nama' => "Ta'lim",
                    'kelompok' => 'C',
                ],
                [
                    // 16
                    'nama' => "Fikih",
                    'kelompok' => 'C',
                ],
                [
                    // 17
                    'nama' => "PABP",
                    'kelompok' => 'C',
                ],
                [
                    // 18
                    'nama' => "Ke NU an",
                    'kelompok' => 'C',
                ],
                [
                    // 19
                    'nama' => "Bahasa Arab",
                    'kelompok' => 'C',
                ],
            ];

        foreach ($data as $mapel) {
            MataPelajaran::create([
                'nama' => $mapel['nama'],
                'kelompok' => $mapel['kelompok']
            ]);
        }
    }
}

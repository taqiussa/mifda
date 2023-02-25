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
                [
                    'nama' => 'Pendidikan Agama Islam',
                    'kelompok' => 'A',
                ],
                [
                    'nama' => 'Pendidikan Kewarganegaraan',
                    'kelompok' => 'A',
                ],
                [
                    'nama' => 'Bahasa Indonesia',
                    'kelompok' => 'A',
                ],
                [
                    'nama' => 'Matematika',
                    'kelompok' => 'A',
                ],
                [
                    'nama' => 'Ilmu Pengetahuan Alam',
                    'kelompok' => 'A',
                ],
                [
                    'nama' => 'Ilmu Pengetahuan Sosial',
                    'kelompok' => 'A',
                ],
                [
                    'nama' => 'Bahasa Inggris',
                    'kelompok' => 'A',
                ],
                [
                    'nama' => 'Seni Budaya',
                    'kelompok' => 'B',
                ],
                [
                    'nama' => 'Pendidikan Jasmani, Olahraga dan Kesehatan',
                    'kelompok' => 'B',
                ],
                [
                    'nama' => 'Informatika',
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

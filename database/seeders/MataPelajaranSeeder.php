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
                'Pendidikan Agama Islam',
                'Pendidikan Kewarganegaraan',
                'Bahasa Indonesia',
                'Matematika',
                'Ilmu Pengetahuan Alam',
                'Ilmu Pengetahuan Sosial',
                'Bahasa Inggris',
                'Seni Budaya',
                'Pendidikan Jasmani, Olahraga dan Kesehatan',
                'Informatika',
            ];

        foreach ($data as $mapel) {
            MataPelajaran::create([
                'nama' => $mapel
            ]);
        }
    }
}

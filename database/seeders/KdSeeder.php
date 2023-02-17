<?php

namespace Database\Seeders;

use App\Models\Kd;
use EnumKategoriNilai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 11; $i++)
        {
            Kd::create([
                'mata_pelajaran_id' => $i,
                'tingkat' => 7,
                'kategori_nilai_id' => EnumKategoriNilai::SUMATIF,
                'jenis_penilaian_id' => 12,
                'tahun' => '2022 / 2023',
                'semester' => 1,
                'deskripsi' => fake()->text()
            ]);

            Kd::create([
                'mata_pelajaran_id' => $i,
                'tingkat' => 7,
                'kategori_nilai_id' => EnumKategoriNilai::SUMATIF,
                'jenis_penilaian_id' => 13,
                'tahun' => '2022 / 2023',
                'semester' => 2,
                'deskripsi' => fake()->text()
            ]);
            
            Kd::create([
                'mata_pelajaran_id' => $i,
                'tingkat' => 8,
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN,
                'jenis_penilaian_id' => 3,
                'tahun' => '2022 / 2023',
                'semester' => 1,
                'deskripsi' => fake()->text()
            ]);

            Kd::create([
                'mata_pelajaran_id' => $i,
                'tingkat' => 8,
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN,
                'jenis_penilaian_id' => 4,
                'tahun' => '2022 / 2023',
                'semester' => 2,
                'deskripsi' => fake()->text()
            ]);

            Kd::create([
                'mata_pelajaran_id' => $i,
                'tingkat' => 9,
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN,
                'jenis_penilaian_id' => 3,
                'tahun' => '2022 / 2023',
                'semester' => 1,
                'deskripsi' => fake()->text()
            ]);

            Kd::create([
                'mata_pelajaran_id' => $i,
                'tingkat' => 9,
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN,
                'jenis_penilaian_id' => 4,
                'tahun' => '2022 / 2023',
                'semester' => 2,
                'deskripsi' => fake()->text()
            ]);
            
        }
    }
}

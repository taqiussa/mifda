<?php

namespace Database\Seeders;

use App\Models\JenisPenilaian;
use EnumKategoriNilai;
use Illuminate\Database\Seeder;

class JenisPenilaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data  = [
            [
                'nama' => 'Tugas 1',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'Tugas 2',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'Tugas 3',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'Tugas 4',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'Penilaian Harian 1',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'Penilaian Harian 2',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'Penilaian Harian 3',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'Penilaian Harian 4',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'Praktek 1',
                'kategori_nilai_id' => EnumKategoriNilai::KETERAMPILAN
            ],
            [
                'nama' => 'Praktek 2',
                'kategori_nilai_id' => EnumKategoriNilai::KETERAMPILAN
            ],
            [
                'nama' => 'Proyek 1',
                'kategori_nilai_id' => EnumKategoriNilai::KETERAMPILAN
            ],
            [
                'nama' => 'Proyek 2',
                'kategori_nilai_id' => EnumKategoriNilai::KETERAMPILAN
            ],
            [
                'nama' => 'PTS',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'PAS',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'PAT',
                'kategori_nilai_id' => EnumKategoriNilai::PENGETAHUAN
            ],
            [
                'nama' => 'Sumatif 1',
                'kategori_nilai_id' => EnumKategoriNilai::SUMATIF
            ],
            [
                'nama' => 'Sumatif 2',
                'kategori_nilai_id' => EnumKategoriNilai::SUMATIF
            ],
            [
                'nama' => 'Sumatif 3',
                'kategori_nilai_id' => EnumKategoriNilai::SUMATIF
            ],
            [
                'nama' => 'Sumatif 4',
                'kategori_nilai_id' => EnumKategoriNilai::SUMATIF
            ],
            [
                'nama' => 'Formatif 1',
                'kategori_nilai_id' => EnumKategoriNilai::FORMATIF
            ],
            [
                'nama' => 'Formatif 2',
                'kategori_nilai_id' => EnumKategoriNilai::FORMATIF
            ],
            [
                'nama' => 'Formatif 3',
                'kategori_nilai_id' => EnumKategoriNilai::FORMATIF
            ],
            [
                'nama' => 'Formatif 4',
                'kategori_nilai_id' => EnumKategoriNilai::FORMATIF
            ],
            [
                'nama' => 'Sumatif Akhir Gasal',
                'kategori_nilai_id' => EnumKategoriNilai::SUMATIF
            ],
            [
                'nama' => 'Sumatif Akhir Genap',
                'kategori_nilai_id' => EnumKategoriNilai::SUMATIF
            ],

        ];

        foreach ($data as $jenis) {
            JenisPenilaian::create([
                'nama' => $jenis['nama'],
                'kategori_nilai_id' => $jenis['kategori_nilai_id']
            ]);
        }
    }
}

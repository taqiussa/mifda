<?php

namespace Database\Seeders;

use App\Models\JenisPenilaian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'Tugas 1',
            'Tugas 2',
            'Ulangan Harian 1',
            'Ulangan Harian 2',
            'Praktek 1',
            'Praktek 2',
            'Proyek 1',
            'Proyek 2',
            'PTS',
            'PAS',
            'PAT',
            'Sumatif 1',
            'Sumatif 2',
            'Formatif 1',
            'Formatif 2',
            'Sumatif Akhir Gasal',
            'Sumatif Akhir Genap',
        ];
        
        foreach ($data as $jenis) {
            JenisPenilaian::create([
                'nama' => $jenis
            ]);
        }
    }
}

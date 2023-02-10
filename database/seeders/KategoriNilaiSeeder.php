<?php

namespace Database\Seeders;

use App\Models\KategoriNilai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriNilaiSeeder extends Seeder
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
            'Pengetahuan',
            'Keterampilan',
            'Sumatif',
            'Formatif'
        ];

        foreach($data as $kategori)
        {
            KategoriNilai::create(['nama' => $kategori]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\KategoriSikap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSikapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriSikap::create([
            'nama' => 'P5'
        ]);
        KategoriSikap::create([
            'nama' => 'Spiritual'
        ]);
        KategoriSikap::create([
            'nama' => 'Sosial'
        ]);
    }
}

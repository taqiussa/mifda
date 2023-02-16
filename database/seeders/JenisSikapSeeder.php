<?php

namespace Database\Seeders;

use App\Models\JenisSikap;
use EnumKategoriSikap;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSikapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nama' => 'Beriman, bertakwa kepada Tuhan Yang Maha Esa, dan berakhlak mulia',
                'kategori_sikap_id' => EnumKategoriSikap::P5
            ],
            [
                'nama' => 'Berkebhinekaan global',
                'kategori_sikap_id' => EnumKategoriSikap::P5
            ],
            [
                'nama' => 'Gotong royong',
                'kategori_sikap_id' => EnumKategoriSikap::P5
            ],
            [
                'nama' => 'Mandiri',
                'kategori_sikap_id' => EnumKategoriSikap::P5
            ],
            [
                'nama' => 'Bernalar kritis',
                'kategori_sikap_id' => EnumKategoriSikap::P5
            ],
            [
                'nama' => 'Kreatif',
                'kategori_sikap_id' => EnumKategoriSikap::P5
            ],
        ];

        foreach ($data as $jenis) {
            JenisSikap::create([
                'nama' => $jenis['nama'],
                'kategori_sikap_id' => $jenis['kategori_sikap_id']
            ]);
        }
    }
}

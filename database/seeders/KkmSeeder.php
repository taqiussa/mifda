<?php

namespace Database\Seeders;

use App\Models\Kkm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KkmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 19; $i++) {
            Kkm::create([
                'mata_pelajaran_id' => $i,
                'tingkat' => 7,
                'tahun' => '2022 / 2023',
                'kkm' => 75
            ]);
            Kkm::create([
                'mata_pelajaran_id' => $i,
                'tingkat' => 8,
                'tahun' => '2022 / 2023',
                'kkm' => 75
            ]);
            Kkm::create([
                'mata_pelajaran_id' => $i,
                'tingkat' => 9,
                'tahun' => '2022 / 2023',
                'kkm' => 75
            ]);
        }
    }
}

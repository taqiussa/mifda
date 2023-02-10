<?php

namespace Database\Seeders;

use App\Models\AturanKurikulum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AturanKurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AturanKurikulum::create([
            'tahun' => '2022 / 2023',
            'kurikulum_id' => 1,
            'tingkat' => 8,
        ]);
        AturanKurikulum::create([
            'tahun' => '2022 / 2023',
            'kurikulum_id' => 1,
            'tingkat' => 9,
        ]);
        AturanKurikulum::create([
            'tahun' => '2022 / 2023',
            'kurikulum_id' => 2,
            'tingkat' => 7,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kurikulum::create(['nama' => 'Kurtilas']);
        Kurikulum::create(['nama' => 'Merdeka']);
    }
}

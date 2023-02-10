<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 2023001; $i < 2023999; $i++) {
            User::create([
                'name' => fake()->name(),
                'username' => $i,
                'nis' => $i,
                'password' => bcrypt('12345678')
            ]);

            Siswa::create([
                'nis' => $i,
                'kelas_id' => random_int(1, 21),
                'tahun' => '2022 / 2023'
            ]);
        }
    }
}

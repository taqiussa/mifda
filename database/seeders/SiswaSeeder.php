<?php

namespace Database\Seeders;

use App\Models\Biodata;
use App\Models\Siswa;
use App\Models\SiswaEkstrakurikuler;
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
        // for ($i = 2023001; $i < 2023301; $i++) {
        //     $user = User::create([
        //         'name' => fake()->name(),
        //         'username' => $i,
        //         'nis' => $i,
        //         'password' => bcrypt('12345678')
        //     ]);

        //     $siswa = Siswa::create([
        //         'nis' => $i,
        //         'kelas_id' => random_int(1, 21),
        //         'tahun' => '2022 / 2023'
        //     ]);

        //     Siswa::create([
        //         'nis' => $i,
        //         'kelas_id' => random_int(1, 21),
        //         'tahun' => '2023 / 2024'
        //     ]);

        //     SiswaEkstrakurikuler::create([
        //         'nis' => $i,
        //         'kelas_id' => $siswa->kelas_id,
        //         'ekstrakurikuler_id' => random_int(1, 17),
        //         'tahun' => '2022 / 2023'
        //     ]);

        //     Biodata::create([
        //         'nis' => $i,
        //         'nik' => 3324223 . $i,
        //         'nisn' => 293 . $i,
        //         'jenis_kelamin' => fake()->randomElement(['L', 'P']),
        //         'tempat_lahir' => fake()->randomElement(['Kendal', 'Semarang', 'Temanggung', 'Magelang']),
        //         'tanggal_lahir' => fake()->date(),
        //     ]);

        //     $user->assignRole('Siswa');
        // }
    }
}

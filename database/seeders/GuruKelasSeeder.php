<?php

namespace Database\Seeders;

use App\Models\GuruKelas;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuruKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mapel = MataPelajaran::create(['nama' => 'Konseling']);
        
        $konseling = User::create(['name' => 'Guru Konseling', 'username' => 'konseling', 'password' => bcrypt('smpmifdaperon')]);
        
        $konseling->assignRole('Guru');

        for ($i = 1; $i < 22; $i++) {
            GuruKelas::create([
                'user_id' => $konseling->id,
                'kelas_id' => $i,
                'mata_pelajaran_id' => $mapel->id,
                'tahun' => '2022 / 2023'
            ]);
        }

        $users = [
            [
                'name' =>
                'Guru Pendidikan Agama Islam 2',
                'username' => 'pai2'
            ],
            [
                'name' =>
                'Guru Pendidikan Kewarganegaraan 2',
                'username' => 'pkn2'
            ],
            [
                'name' =>
                'Guru Bahasa Indonesia 2',
                'username' => 'indonesia2'
            ],
            [
                'name' =>
                'Guru Matematika 2',
                'username' => 'matematika2'
            ],
            [
                'name' =>
                'Guru Ilmu Pengetahuan Alam 2',
                'username' => 'ipa2'
            ],
            [
                'name' =>
                'Guru Ilmu Pengetahuan Sosial 2',
                'username' => 'ips2'
            ],
            [
                'name' =>
                'Guru Bahasa Inggris 2',
                'username' => 'inggris2'
            ],
            [
                'name' =>
                'Guru Seni Budaya 2',
                'username' => 'seni2'
            ],
            [
                'name' =>
                'Guru Pendidikan Jasmani, Olahraga dan Kesehatan 2',
                'username' => 'pjok2'
            ],
            [
                'name' =>
                'Guru Informatika 2',
                'username' => 'informatika2'
            ],

        ];


        foreach ($users as $key => $user) {
            $data = User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'password' => bcrypt('smpmifdaperon')
            ]);

            $data->assignRole('Guru');
            $data->mapels()->attach($key + 1);

            $data->kelas()->createMany([
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 8
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 9
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 10
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 11
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 12
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 13
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 14
                ],
            ]);

            $data->waliKelas()->create([
                'kelas_id' => $key + 8,
                'tahun' => '2022 / 2023'
            ]);
        }

        $users2 = [
            [
                'name' =>
                'Guru Pendidikan Agama Islam 3',
                'username' => 'pai3'
            ],
            [
                'name' =>
                'Guru Pendidikan Kewarganegaraan 3',
                'username' => 'pkn3'
            ],
            [
                'name' =>
                'Guru Bahasa Indonesia 3',
                'username' => 'indonesia3'
            ],
            [
                'name' =>
                'Guru Matematika 3',
                'username' => 'matematika3'
            ],
            [
                'name' =>
                'Guru Ilmu Pengetahuan Alam 3',
                'username' => 'ipa3'
            ],
            [
                'name' =>
                'Guru Ilmu Pengetahuan Sosial 3',
                'username' => 'ips3'
            ],
            [
                'name' =>
                'Guru Bahasa Inggris 3',
                'username' => 'inggris3'
            ],
            [
                'name' =>
                'Guru Seni Budaya 3',
                'username' => 'seni3'
            ],
            [
                'name' =>
                'Guru Pendidikan Jasmani, Olahraga dan Kesehatan 3',
                'username' => 'pjok3'
            ],
            [
                'name' =>
                'Guru Informatika 3',
                'username' => 'informatika3'
            ],
        ];

        foreach ($users2 as $key => $user) {
            $data = User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'password' => bcrypt('smpmifdaperon')
            ]);

            $data->assignRole('Guru');

            $data->mapels()->attach($key + 1);

            $data->kelas()->createMany([
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 15
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 16
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 17
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 18
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 19
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 20
                ],
                [
                    'tahun' => '2022 / 2023',
                    'mata_pelajaran_id' => $key + 1,
                    'kelas_id' => 21
                ],
            ]);

            $data->waliKelas()->create([
                'kelas_id' => $key + 15,
                'tahun' => '2022 / 2023'
            ]);
        }
    }
}

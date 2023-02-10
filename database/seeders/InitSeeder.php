<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class InitSeeder extends Seeder
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
                'Kepala Sekolah',
                'Kurikulum',
                'Kesiswaan',
                'Guru',
                'Siswa'
            ];

        foreach ($data as $name) {
            Role::create([
                'name' => $name,
                'guard_name' => 'web'
            ]);
        }

        $users = [
            [
                'name' =>
                'Guru Pendidikan Agama Islam',
                'username' => 'pai'
            ],
            [
                'name' =>
                'Guru Pendidikan Kewarganegaraan',
                'username' => 'pkn'
            ],
            [
                'name' =>
                'Guru Bahasa Indonesia',
                'username' => 'indonesia'
            ],
            [
                'name' =>
                'Guru Matematika',
                'username' => 'matematika'
            ],
            [
                'name' =>
                'Guru Ilmu Pengetahuan Alam',
                'username' => 'ipa'
            ],
            [
                'name' =>
                'Guru Ilmu Pengetahuan Sosial',
                'username' => 'ips'
            ],
            [
                'name' =>
                'Guru Bahasa Inggris',
                'username' => 'inggris'
            ],
            [
                'name' =>
                'Guru Seni Budaya',
                'username' => 'seni'
            ],
            [
                'name' =>
                'Guru Pendidikan Jasmani, Olahraga dan Kesehatan',
                'username' => 'pjok'
            ],
            [
                'name' =>
                'Guru Informatika',
                'username' => 'informatika'
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
                    'kelas_id' => 1
                ],
                [
                    'tahun' => '2022 / 2023',
                    'kelas_id' => 2
                ],
                [
                    'tahun' => '2022 / 2023',
                    'kelas_id' => 3
                ],
                [
                    'tahun' => '2022 / 2023',
                    'kelas_id' => 4
                ],
                [
                    'tahun' => '2022 / 2023',
                    'kelas_id' => 5
                ],
                [
                    'tahun' => '2022 / 2023',
                    'kelas_id' => 6
                ],
                [
                    'tahun' => '2022 / 2023',
                    'kelas_id' => 7
                ],
            ]);
        }

        $datas =
            [
                [
                    'name' =>
                    'Agus Arif Fahmie, S.Pd',
                    'username' => 'fahmie'
                ],
                [
                    'name' =>
                    'Guru Kurikulum',
                    'username' => 'kurikulum'
                ],
                [
                    'name' =>
                    'Guru Kesiswaan',
                    'username' => 'kesiswaan'
                ],
            ];

        foreach ($datas as $data) {
            $data = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'password' => bcrypt('smpmifdaperon')
            ]);

            $data->assignRole('Guru');
        }

        $fahmie = User::whereUsername('fahmie')->first();
        $fahmie->assignRole('Kepala Sekolah');
        $kurikulum = User::whereUsername('kurikulum')->first();
        $kurikulum->assignRole('Kurikulum');
        $kesiswaan = User::whereUsername('kesiswaan')->first();
        $kesiswaan->assignRole('Kesiswaan');
    }
}

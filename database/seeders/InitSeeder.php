<?php

namespace Database\Seeders;

use App\Models\GuruMataPelajaran;
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
                'name' =>  'Cahya Widi Rahayu',
                'username' => 'widi',
                'mata_pelajaran_id' => 9
            ],
            [
                'name' =>  'Hepy Puji S,S.Pd',
                'username' => 'hepy',
                'mata_pelajaran_id' => 9
            ],
            [
                'name' =>  'Adieb Ajie Bayu Mukti,S.Pd',
                'username' => 'ajie',
                'mata_pelajaran_id' => 4
            ],
            [
                'name' =>  'Assabun Nuzul',
                'username' => 'nuzul',
                'mata_pelajaran_id' => 12
            ],
            [
                'name' =>  'Nanang Kurnianto,S.Pd',
                'username' => 'nanang',
                'mata_pelajaran_id' => 10
            ],
            [
                'name' =>  'Dyah Pertiwi,S.Pd',
                'username' => 'pertiwi',
                'mata_pelajaran_id' => 2
            ],
            [
                'name' =>  'Anggita Perwitasari,S.Pd',
                'username' => 'anggi',
                'mata_pelajaran_id' => 3
            ],
            [
                'name' =>  'L. Nurzayyana Anita F.,S.Pd',
                'username' => 'anita',
                'mata_pelajaran_id' => 16
            ],
            [
                'name' =>  'M. Awalul Husna',
                'username' => 'alul',
                'mata_pelajaran_id' => 14
            ],
            [
                'name' =>  'Zulfa Aulia Rosada A.',
                'username' => 'zulfa',
                'mata_pelajaran_id' => 8
            ],
            [
                'name' =>  'Hanna Azizah,S.Pd',
                'username' => 'hanna',
                'mata_pelajaran_id' => 7
            ],
            [
                'name' =>  'Ahmad Arikza Hudaefi,S.Pd',
                'username' => 'arikza',
                'mata_pelajaran_id' => 13
            ],
            [
                'name' =>  'Shabila Maurarin Rizqi',
                'username' => 'shabila',
                'mata_pelajaran_id' => 7
            ],
            [
                'name' =>  'Nasrul Khusaeni',
                'username' => 'nasrul',
                'mata_pelajaran_id' => 6
            ],
            [
                'name' =>  'Doni Setyawan,S.Pd',
                'username' => 'doni',
                'mata_pelajaran_id' => 9
            ],
            [
                'name' =>  'Wahib Abdul Rohim',
                'username' => 'wahib',
                'mata_pelajaran_id' => 11
            ],
            [
                'name' =>  'Nur Fadhillah,S.Pd',
                'username' => 'dhila',
                'mata_pelajaran_id' => 6
            ],
            [
                'name' =>  'Ilzam Mashuri,S.Pd',
                'username' => 'ilzam',
                'mata_pelajaran_id' => 17
            ],
            [
                'name' =>  'Rifa Wahyuningsih,S.Pd',
                'username' => 'rifa',
                'mata_pelajaran_id' => 3
            ],
            [
                'name' =>  'Dyah Prawanti,S.Pd',
                'username' => 'prawanti',
                'mata_pelajaran_id' => 8
            ],
            [
                'name' =>  'Muchamad Ghufron',
                'username' => 'ghufron',
                'mata_pelajaran_id' => 15
            ],
            [
                'name' =>  'Nur Huda,S.Pd.I',
                'username' => 'huda',
                'mata_pelajaran_id' => 19
            ],
            [
                'name' =>  'Ahmad Ula Khabib,S.Pd',
                'username' => 'khabib',
                'mata_pelajaran_id' => 18
            ],
        ];

        foreach ($users as $key => $user) {
            $data = User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'password' => bcrypt('smpmifdaperon')
            ]);

            $data->assignRole('Guru');

            GuruMataPelajaran::create([
                'user_id' => $data->id,
                'mata_pelajaran_id' => $user['mata_pelajaran_id']
            ]);

            $data->waliKelas()->create([
                'kelas_id' => $key + 1,
                'tahun' => '2022 / 2023'
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
                    'Nurul Farida,S.HI',
                    'username' => 'nurul'
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
    }
}

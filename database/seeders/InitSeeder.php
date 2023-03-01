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
                'Admin',
                'Kepala Sekolah',
                'Bendahara',
                'Kurikulum',
                'Kesiswaan',
                'Tata Usaha',
                'Konseling',
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
                'foto' => '',
                'mata_pelajaran_id' => 9
            ],
            [
                'name' =>  'Hepy Puji S,S.Pd',
                'username' => 'hepy',
                'foto' => 'user.png',
                'mata_pelajaran_id' => 9
            ],
            [
                'name' =>  'Adieb Ajie Bayu Mukti,S.Pd',
                'username' => 'ajie',
                'foto' => '',
                'mata_pelajaran_id' => 4
            ],
            [
                'name' =>  'Assabun Nuzul',
                'username' => 'nuzul',
                'foto' => '',
                'mata_pelajaran_id' => 12
            ],
            [
                'name' =>  'Nanang Kurnianto,S.Pd',
                'username' => 'nanang',
                'foto' => '',
                'mata_pelajaran_id' => 10
            ],
            [
                'name' =>  'Dyah Pertiwi,S.Pd',
                'username' => 'pertiwi',
                'foto' => '',
                'mata_pelajaran_id' => 2
            ],
            [
                'name' =>  'Anggita Perwitasari,S.Pd',
                'username' => 'anggi',
                'foto' => '',
                'mata_pelajaran_id' => 3
            ],
            [
                'name' =>  'L. Nurzayyana Anita F.,S.Pd',
                'username' => 'anita',
                'foto' => '',
                'mata_pelajaran_id' => 16
            ],
            [
                'name' =>  'M. Awalul Husna',
                'username' => 'alul',
                'foto' => '',
                'mata_pelajaran_id' => 14
            ],
            [
                'name' =>  'Zulfa Aulia Rosada A.',
                'username' => 'zulfa',
                'foto' => '',
                'mata_pelajaran_id' => 8
            ],
            [
                'name' =>  'Hanna Azizah,S.Pd',
                'username' => 'hanna',
                'foto' => '',
                'mata_pelajaran_id' => 7
            ],
            [
                'name' =>  'Ahmad Arikza Hudaefi,S.Pd',
                'username' => 'arikza',
                'foto' => '',
                'mata_pelajaran_id' => 13
            ],
            [
                'name' =>  'Shabila Maurarin Rizqi',
                'username' => 'shabila',
                'foto' => '',
                'mata_pelajaran_id' => 7
            ],
            [
                'name' =>  'Nasrul Khusaeni',
                'username' => 'nasrul',
                'foto' => '',
                'mata_pelajaran_id' => 6
            ],
            [
                'name' =>  'Doni Setyawan,S.Pd',
                'username' => 'doni',
                'foto' => '',
                'mata_pelajaran_id' => 9
            ],
            [
                'name' =>  'Wahib Abdul Rohim',
                'username' => 'wahib',
                'foto' => '',
                'mata_pelajaran_id' => 11
            ],
            [
                'name' =>  'Nur Fadhillah,S.Pd',
                'username' => 'dhila',
                'foto' => '',
                'mata_pelajaran_id' => 6
            ],
            [
                'name' =>  'Ilzam Mashuri,S.Pd',
                'username' => 'ilzam',
                'foto' => '',
                'mata_pelajaran_id' => 17
            ],
            [
                'name' =>  'Rifa Wahyuningsih,S.Pd',
                'username' => 'rifa',
                'foto' => '',
                'mata_pelajaran_id' => 3
            ],
            [
                'name' =>  'Dyah Prawanti,S.Pd',
                'username' => 'prawanti',
                'foto' => '',
                'mata_pelajaran_id' => 8
            ],
            [
                'name' =>  'Muchamad Ghufron',
                'username' => 'ghufron',
                'foto' => '',
                'mata_pelajaran_id' => 15
            ],
            [
                'name' =>  'Nur Huda,S.Pd.I',
                'username' => 'huda',
                'foto' => '',
                'mata_pelajaran_id' => 19
            ],
            [
                'name' =>  'Ahmad Ula Khabib,S.Pd',
                'username' => 'khabib',
                'foto' => '',
                'mata_pelajaran_id' => 18
            ],
        ];

        foreach ($users as $key => $user) {
            $data = User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'foto' => $user['foto'],
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

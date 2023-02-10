<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'kurikulum',
                'kepala sekolah',
                'guru'
            ];
            
        foreach ($data as $user) {
            User::create(
                [
                    'name' => fake()->name(),
                    'username' => $user,
                    'password' => bcrypt('smpmifdaperon')
                ]
            );
        }
    }
}

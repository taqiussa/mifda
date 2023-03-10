<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            KelasSeeder::class,
            MataPelajaranSeeder::class,
            InitSeeder::class,
            KehadiranSeeder::class,
            KurikulumSeeder::class,
            AturanKurikulumSeeder::class,
            JenisPenilaianSeeder::class,
            KategoriNilaiSeeder::class,
            // PenilaianRaporSeeder::class,
            EkstrakurikulerSeeder::class,
            KategoriSikapSeeder::class,
            JenisSikapSeeder::class,
            KkmSeeder::class,
            KdSeeder::class,

            // SiswaSeeder::class,
        ]);
    }
}

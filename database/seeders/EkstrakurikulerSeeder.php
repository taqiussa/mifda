<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EkstrakurikulerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ekstras = [
            "Pramuka",
            "Al Qur'an",
            "Pagar Nusa",
            "Rebana",
            "Voli",
            "Futsal"

        ];

        foreach ($ekstras as $ekstra) {
            Ekstrakurikuler::create(
                [
                    'nama' => $ekstra
                ]
            );
        }
    }
}

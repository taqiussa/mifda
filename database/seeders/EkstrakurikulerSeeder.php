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
            'Pramuka',
            'Sepak Bola',
            'Voli',
            'Tilawah',
            'Tartil',
            'Club Bahasa Indonesia',
            'Club Bahasa Inggris',
            'KIR',
            'Club IPS',
            'Club Matematika',
            'Club Bahasa Jawa',
            'Club Bahasa Arab',
            'Tahfidz',
            'Kaligrafi',
            'Fiqih Ubudiyah',
            'Sepak Takraw',
            'Club Computer',
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

<?php

namespace Database\Seeders;

use App\Models\Kehadiran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KehadiranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Hadir',
            'Sakit',
            'Izin',
            'Alpha',
            'Bolos'
        ];
        foreach($data as $kehadiran)
        {
            Kehadiran::create(['nama' => $kehadiran]);
        }
    }
}

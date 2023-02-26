<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
        foreach ($data as $kelas) {
            Kelas::create([
                'tingkat' => 7,
                'nama' => '7.' . $kelas,
            ]);
        }
        foreach ($data as $kelas) {
            Kelas::create([
                'tingkat' => 8,
                'nama' => '8.' . $kelas,
            ]);
        }
        foreach ($data as $kelas) {
            Kelas::create([
                'tingkat' => 9,
                'nama' => '9.' . $kelas,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\WaliKelas;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class PrintRaporController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintRapor',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::get(),
                'initKelasId' => WaliKelas::whereTahun($this->data_tahun())
                    ->whereUserId(auth()->user()->id)
                    ->value('kelas_id')
            ]
        );
    }

    public function print()
    {
    }
}

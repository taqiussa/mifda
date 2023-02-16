<?php

namespace App\Http\Controllers;

use App\Models\AturanKurikulum;
use App\Models\Kelas;
use App\Models\WaliKelas;
use App\Traits\InitTrait;

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
        $kelas = request('kelasId');
        $tahun = request('tahun');
        $semester = request('semester');

        $cekKurikulum = AturanKurikulum::whereTingkat();
    }
}

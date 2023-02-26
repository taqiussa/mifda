<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use App\Models\Kelas;
use App\Models\WaliKelas;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class InputCatatanController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/InputCatatan',
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

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'kelasId' => 'required',
            'nis' => 'required',
        ]);

        Catatan::updateOrCreate(
            [
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'kelas_id' => request('kelasId'),
                'nis' => request('nis'),
            ],
            [
                'catatan' => request('catatan')
            ]
        );

        return to_route('input-catatan');
    }
}

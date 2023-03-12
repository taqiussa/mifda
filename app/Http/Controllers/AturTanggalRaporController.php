<?php

namespace App\Http\Controllers;

use App\Models\TanggalRapor;
use App\Traits\InitTrait;

class AturTanggalRaporController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/AturTanggalRapor',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listTanggal' => TanggalRapor::orderBy('tahun')
                    ->orderBy('semester')
                    ->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate(
            [
                'tahun' => 'required',
                'semester' => 'required',
                'tanggal' => 'required'
            ]
        );

        TanggalRapor::updateOrCreate(
            [
                'tahun' => request('tahun'),
                'semester' => request('semester')
            ],
            [
                'tanggal' => request('tanggal')
            ]
        );

        return to_route('atur-tanggal-rapor');
    }

    public function hapus()
    {
        TanggalRapor::destroy(request('id'));

        return to_route('atur-tanggal-rapor');
    }
}

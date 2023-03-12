<?php

namespace App\Http\Controllers;

use App\Models\Kkm;
use App\Traits\InitTrait;

class InputKkmController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/InputKkm', [
            'initTahun' => $this->data_tahun(),
        ]);
    }

    public function simpan()
    {
        request()->validate(
            [
                'mataPelajaranId' => 'required',
                'tingkat' => 'required',
                'tahun' => 'required',
                'kkm' => 'required'
            ]
        );

        Kkm::updateOrCreate(
            [
                'tahun' => request('tahun'),
                'tingkat' => request('tingkat'),
                'mata_pelajaran_id' => request('mataPelajaranId')
            ],
            ['kkm' => request('kkm')]
        );

        return to_route('input-kkm');
    }

    public function hapus()
    {
        Kkm::destroy(request('id'));

        return to_route('input-kkm');
    }
}

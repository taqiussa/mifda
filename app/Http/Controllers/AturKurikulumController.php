<?php

namespace App\Http\Controllers;

use App\Models\AturanKurikulum;
use App\Models\Kurikulum;
use App\Traits\InitTrait;

class AturKurikulumController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/AturKurikulum',
            [
                'initTahun' => $this->data_tahun(),
                'listKurikulum' => Kurikulum::orderBy('nama')->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate(
            [
                'tahun' => 'required',
                'kurikulumId' => 'required',
                'tingkat' => 'required'
            ]
        );

        AturanKurikulum::create(
            [
                'tahun' => request('tahun'),
                'kurikulum_id' => request('kurikulumId'),
                'tingkat' => request('tingkat')
            ]
        );

        return to_route('atur-kurikulum');
    }

    public function hapus($id)
    {
        AturanKurikulum::destroy($id);

        return to_route('atur-kurikulum');
    }
}

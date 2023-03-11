<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use App\Models\WaliKelas;
use App\Traits\InitTrait;

class AturWaliKelasController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/AturWaliKelas',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get(),
                'listUser' => User::role('Guru')->orderBy('name')->get(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'kelasId' => 'required',
            'userId' => 'required',
            'tahun' => 'required'
        ]);

        WaliKelas::updateOrCreate(
            [
                'kelas_id' => request('kelasId'),
                'tahun' => request('tahun')
            ],
            [
                'user_id' => request('userId')
            ]
        );

        return to_route('atur-wali-kelas');
    }

    public function hapus()
    {
        WaliKelas::destroy(request('id'));

        return to_route('atur-wali-kelas');
    }
}

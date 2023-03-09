<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\User;
use App\Traits\InitTrait;

class AturGuruKelasController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/AturGuruKelas',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::get(),
                'listMataPelajaran' => MataPelajaran::orderBy('nama')->get(),
                'listUser' => User::role('Guru')->orderBy('name')->get(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'userId' => 'required',
            'mataPelajaranId' => 'required',
            'kelasId' => 'required'
        ]);

        GuruKelas::create(
            [
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'user_id' => request('userId'),
                'kelas_id' => request('kelasId')
            ]
        );

        return to_route('atur-guru-kelas');
    }

    public function hapus()
    {
        GuruKelas::destroy(request('id'));

        return to_route('atur-guru-kelas');
    }
}

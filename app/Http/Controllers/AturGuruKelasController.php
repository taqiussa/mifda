<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\Kelas;
use App\Models\User;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

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
                'listUser' => User::role('Guru')->get(),
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
}

<?php

namespace App\Http\Controllers;

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
    }
}

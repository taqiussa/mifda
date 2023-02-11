<?php

namespace App\Http\Controllers;

use App\Models\GuruMataPelajaran;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class InputNilaiController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilai',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMataPelajaran' => GuruMataPelajaran::whereUserId(auth()->user()->id)
                    ->with([
                        'mapel'
                    ])
                    ->get(),
            ]
        );
    }
}

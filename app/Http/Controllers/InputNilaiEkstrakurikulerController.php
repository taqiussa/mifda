<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Traits\InitTrait;

class InputNilaiEkstrakurikulerController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/InputNilaiEkstrakurikuler', [
            'initTahun' => $this->data_tahun(),
            'initSemester' => $this->data_semester(),
            'listEkstrakurikuler' => Ekstrakurikuler::orderBy('nama')->get(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use Illuminate\Http\Request;
use App\Models\GuruMataPelajaran;

class UploadNilaiController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadNilai',
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

    public function upload(Request $request)
    {
        $request->validate([
            'fileImport' => 'required|mimes:xls,xlsx'
        ]);
    }
}

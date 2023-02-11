<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class GetPenilaianController extends Controller
{
    use InitTrait;

    public function get_nilai_siswa(Request $request)
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun($request->tahun)
            ->whereKelasId($request->kelasId)
            ->with([
                'nilai' => fn($q) => $q->whereTahun($request->tahun)
                ->whereSemester($request->semester)
                ->whereMataPelajaranId($request->mataPelajaranId)
            ])
        ]);
    }
}

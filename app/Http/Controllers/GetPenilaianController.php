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
                    'user' => fn ($q) => $q->select('nis', 'name'),
                    'nilai' => fn ($q) => $q
                        ->whereTahun($request->tahun)
                        ->whereSemester($request->semester)
                        ->whereMataPelajaranId($request->mataPelajaranId)
                        ->whereKategoriNilaiId($request->kategoriNilaiId)
                        ->whereJenisPenilaianId($request->jenisPenilaianId)
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_nilai_sikap(Request $request)
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun($request->tahun)
                ->whereKelasId($request->kelasId)
                ->with([
                    'user' => fn ($q) => $q->select('nis', 'name'),
                    'nilaiSikap' => fn ($q) => $q
                        ->whereTahun($request->tahun)
                        ->whereSemester($request->semester)
                        ->whereMataPelajaranId($request->mataPelajaranId)
                        ->whereKategoriSikapId($request->kategoriSikapId)
                        ->whereJenisSikapId($request->jenisSikapId)
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }
}

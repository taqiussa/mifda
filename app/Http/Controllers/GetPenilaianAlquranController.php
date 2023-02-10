<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use App\Models\JenisAlquran;
use Illuminate\Http\Request;

class GetPenilaianAlquranController extends Controller
{
    use InitTrait;

    public function get_nilai_alquran_siswa(Request $request)
    {

        return response()->json([
            'listNilai' => JenisAlquran::with([
                'nilai' => fn ($q) => $q->whereNis($request->nis),
                'nilai.guru' => fn ($q) => $q->select('id', 'name'),
            ])
                ->get()
        ]);
    }

    public function get_jenis_alquran(Request $request)
    {

        return response()->json([
            'listJenisAlquran' => JenisAlquran::whereKategoriAlquranId($request->kategoriAlquranId)
                ->get()
        ]);
    }
}

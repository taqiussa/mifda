<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\SiswaEkstrakurikuler;
use App\Traits\InitTrait;

class GetPenilaianController extends Controller
{
    use InitTrait;

    public function get_nilai_ekstrakurikuler()
    {
        return response()->json([
            'listSiswa' => SiswaEkstrakurikuler::whereTahun(request('tahun'))
                ->whereEkstrakurikulerId(request('ekstrakurikulerId'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'nilai' => fn ($q) => $q
                        ->whereTahun(request('tahun'))
                        ->whereSemester(request('semester')),
                    'user' => fn ($q) => $q->select('nis', 'name'),
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_nilai_siswa()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'user' => fn ($q) => $q->select('nis', 'name'),
                    'nilai' => fn ($q) => $q
                        ->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                        ->whereMataPelajaranId(request('mataPelajaranId'))
                        ->whereKategoriNilaiId(request('kategoriNilaiId'))
                        ->whereJenisPenilaianId(request('jenisPenilaianId'))
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_nilai_sikap()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'user' => fn ($q) => $q->select('nis', 'name'),
                    'nilaiSikap' => fn ($q) => $q
                        ->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                        ->whereMataPelajaranId(request('mataPelajaranId'))
                        ->whereKategoriSikapId(request('kategoriSikapId'))
                        ->whereJenisSikapId(request('jenisSikapId'))
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }
}

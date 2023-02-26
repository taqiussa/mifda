<?php

namespace App\Http\Controllers;

use App\Models\AturanKurikulum;
use App\Models\Catatan;
use App\Models\GuruKelas;
use App\Models\GuruMataPelajaran;
use App\Models\JenisPenilaian;
use App\Models\JenisSikap;
use App\Models\KategoriNilai;
use App\Models\Kelas;
use App\Models\PenilaianRapor;
use App\Models\Siswa;
use App\Models\SiswaEkstra;
use App\Models\WaliKelas;

class GetDataController extends Controller
{
    public function get_catatan()
    {
        return response()->json([
            'listCatatan' => Catatan::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy(['user.name'])
                ->values()
        ]);
    }

    // public function get_ekstrakurikuler()
    // {
    //     return response()->json([
    //         'listSiswa' => SiswaEkstra::whereTahun(request('tahun'))
    //             ->whereKelasId(request('kelasId'))
    //             ->with([
    //                 'ekstrakurikuler',
    //                 'user'
    //             ])
    //             ->get()
    //             ->sortBy(['user.name'])
    //             ->values()
    //     ]);
    // }

    public function get_guru_kelas()
    {
        return response()->json([
            'listGuruKelas' => GuruKelas::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->with([
                    'kelas',
                    'mapel',
                    'user' => fn ($q) => $q->select('id', 'name')
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_jenis_penilaian()
    {
        $tingkat = Kelas::find(request('kelasId'))->tingkat;
        $jenisPenilaianId = PenilaianRapor::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereTingkat($tingkat)
            ->whereKategoriNilaiId(request('kategoriNilaiId'))
            ->pluck('jenis_penilaian_id');
        return response()->json([
            'listJenis' => JenisPenilaian::whereIn('id', $jenisPenilaianId)->get()
        ]);
    }

    public function get_jenis_sikap()
    {
        return response()->json([
            'listJenis' => JenisSikap::whereKategoriSikapId(request('kategoriSikapId'))->get()
        ]);
    }

    public function get_kategori_nilai()
    {
        $tingkat = Kelas::find(request('kelasId'))->tingkat;
        $kurikulum = AturanKurikulum::whereTahun(request('tahun'))
            ->whereTingkat($tingkat)
            ->with(['kurikulum' => fn ($q) => $q->select('id', 'nama')])
            ->first()->kurikulum->nama;
        if ($kurikulum == 'K13') {
            $kategori = KategoriNilai::whereIn('nama', ['Pengetahuan', 'Keterampilan'])->get();
        } else {
            $kategori = KategoriNilai::whereIn('nama', ['Formatif', 'Sumatif'])->get();
        }

        return response()->json([
            'listKategori' => $kategori
        ]);
    }


    public function get_kelas()
    {
        return response()->json([
            'listKelas' => GuruKelas::with(['kelas' => fn ($q) => $q->select('id', 'nama')])
                ->whereUserId(auth()->user()->id)
                ->whereMataPelajaranId(request('mataPelajaranId'))
                ->whereTahun(request('tahun'))
                ->get(),
        ]);
    }

    public function get_kelas_wali()
    {
        return response()->json([
            'kelasId' => WaliKelas::whereUserId(auth()->user()->id)
                ->whereTahun(request('tahun'))
                ->value('kelas_id') ?? '',
        ]);
    }

    public function get_mata_pelajaran()
    {
        return response()->json([
            'listMataPelajaran' => GuruMataPelajaran::whereUserId(request('userId'))
                ->with([
                    'mapel'
                ])
                ->get()
        ]);
    }

    public function get_siswa()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with(['user' => fn ($q) => $q->select('nis', 'name')])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }
}

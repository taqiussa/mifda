<?php

namespace App\Http\Controllers;

use App\Models\AturanKurikulum;
use App\Models\GuruKelas;
use App\Models\JenisPenilaian;
use App\Models\JenisSikap;
use App\Models\KategoriNilai;
use App\Models\Kelas;
use App\Models\PenilaianRapor;
use App\Models\Siswa;
use App\Models\SiswaEkstra;
use Illuminate\Http\Request;

class GetDataController extends Controller
{
    public function get_ekstrakurikuler(Request $request)
    {
        return response()->json([
            'listSiswa' => SiswaEkstra::whereTahun($request->tahun)
                ->whereKelasId($request->kelasId)
                ->with([
                    'ekstrakurikuler',
                    'user'
                ])
                ->get()
                ->sortBy(['user.name'])
                ->values()
        ]);
    }

    public function get_jenis_penilaian(Request $request)
    {
        $tingkat = Kelas::find($request->kelasId)->tingkat;
        $jenisPenilaianId = PenilaianRapor::whereTahun($request->tahun)
            ->whereSemester($request->semester)
            ->whereTingkat($tingkat)
            ->whereKategoriNilaiId($request->kategoriNilaiId)
            ->pluck('jenis_penilaian_id');
        return response()->json([
            'listJenis' => JenisPenilaian::whereIn('id', $jenisPenilaianId)->get()
        ]);
    }

    public function get_jenis_sikap(Request $request)
    {
        return response()->json([
            'listJenis' => JenisSikap::whereKategoriSikapId($request->kategoriSikapId)->get()
        ]);
    }

    public function get_kategori_nilai(Request $request)
    {
        $tingkat = Kelas::find($request->kelasId)->tingkat;
        $kurikulum = AturanKurikulum::whereTahun($request->tahun)
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


    public function get_kelas(Request $request)
    {
        return response()->json([
            'listKelas' => GuruKelas::with(['kelas' => fn ($q) => $q->select('id', 'nama')])
                ->whereUserId(auth()->user()->id)
                ->whereMataPelajaranId($request->mataPelajaranId)
                ->whereTahun($request->tahun)
                ->get(),
        ]);
    }

    public function get_siswa(Request $request)
    {

        return response()->json([
            'listSiswa' => Siswa::whereTahun($request->tahun)
                ->whereKelasId($request->kelasId)
                ->with(['user' => fn ($q) => $q->select('nis', 'name')])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }
}

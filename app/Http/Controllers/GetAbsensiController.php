<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Traits\InitTrait;
use App\Models\RuangUjian;
use App\Models\SiswaEkstra;
use Illuminate\Http\Request;

class GetAbsensiController extends Controller
{

    use InitTrait;

    public function get_absensi_siswa(Request $request)
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun($request->tahun)
                ->whereKelasId($request->kelasId)
                ->with(
                    [
                        'user' => fn ($q) => $q->select('nis', 'name'),
                        'absensi' => fn ($q) => $q
                            ->whereTanggal($request->tanggal)
                            ->whereJam($request->jam),
                        'absensi.guru' => fn ($q) => $q->select('id', 'name'),
                    ]
                )
                ->get()
                ->sortBy('user.name')
                ->values(),
        ]);
    }

    public function get_absensi_ekstrakurikuler(Request $request)
    {
        return response()->json([
            'listSiswa' => SiswaEkstra::whereTahun($request->tahun)
                ->whereEkstrakurikulerId($request->ekstrakurikulerId)
                ->with(
                    [
                        'user' => fn ($q) => $q->select('nis', 'name'),
                        'biodata' => fn ($q) => $q->select('nis', 'jenis_kelamin'),
                        'kelas' => fn ($q) => $q->select('id', 'nama'),
                        'absensi' => fn ($q) => $q
                            ->whereTanggal($request->tanggal)
                            ->whereEkstrakurikulerId($request->ekstrakurikulerId),
                        'absensi.guru'  => fn ($q) => $q->select('id', 'name'),
                    ]
                )
                ->get()
                ->sortBy(['user.name'])
                ->values(),
        ]);
    }

    public function get_absensi_ujian(Request $request)
    {
        return response()->json([
            'listSiswa' => RuangUjian::whereTahun($request->tahun)
                ->whereSemester($request->semester)
                ->whereNamaRuang($request->namaRuang)
                ->whereNamaUjian($request->namaUjian)
                ->with(
                    [
                        'user' => fn ($q) => $q->select('nis', 'name'),
                        'kelas' => fn ($q) => $q->select('id', 'nama'),
                        'absensi' => fn ($q) => $q
                            ->whereTanggal($request->tanggal)
                            ->whereJam($request->jam),
                        'absensi.guru' => fn ($q) => $q->select('id', 'name'),
                    ]
                )
                ->get()
                ->sortBy(['kelas.nama', 'user.name'])
                ->values(),
        ]);
    }
}

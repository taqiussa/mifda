<?php

namespace App\Http\Controllers;

use EnumKehadiran;
use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Traits\InitTrait;
use App\Models\RuangUjian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AbsensiUjianController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/AbsensiUjian',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKehadiran' => Kehadiran::get(),
            ]
        );
    }

    public function simpan()
    {
        $inputs = request('arrayInput');
        $validator = Validator::make($inputs, [
            '*.absensi.kehadiran_id' => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withErrors(['pesan' => 'Periksa Data, Kehadiran tidak boleh kosong']);
        }

        $tanggal = request('tanggal');
        $tahun = request('tahun');
        $jam = request('jam');
        $semester = $this->data_semester();
        $userId = auth()->user()->id;

        foreach ($inputs as $input) {
            Absensi::updateOrCreate(
                [
                    'tanggal' => $tanggal,
                    'tahun' => $tahun,
                    'jam' => $jam,
                    'kelas_id' => $input['kelas_id'],
                    'semester' => $semester,
                    'nis' => $input['nis'],
                ],
                [
                    'kehadiran_id' => $input['absensi']['kehadiran_id'],
                    'user_id' => $userId
                ]
            );
        }
        return to_route('absensi-ujian');
    }

    // public function nihil()
    // {
    //     request()->validate(
    //         [
    //             'tanggal' => 'required',
    //             'tahun' => 'required',
    //             'jam' => 'required',
    //             'namaRuang' => 'required',
    //             'namaUjian' => 'required',
    //             'semester' => 'required'
    //         ]
    //     );

    //     $tanggal = request('tanggal');
    //     $tahun = request('tahun');
    //     $jam = request('jam');
    //     $namaRuang = request('namaRuang');
    //     $namaUjian = request('namaUjian');
    //     $semester = request('semester');
    //     $userId = auth()->user()->id;
    //     $kehadiranId = EnumKehadiran::HADIR;
    //     $data = [];

    //     $listSiswa = RuangUjian::whereTahun($tahun)
    //         ->whereSemester($semester)
    //         ->whereNamaRuang($namaRuang)
    //         ->whereNamaUjian($namaUjian)
    //         ->get();

    //     $cekTidakHadir = Absensi::whereTanggal($tanggal)
    //         ->whereJam($jam)
    //         ->whereIn('nis', $listSiswa->pluck('nis'))
    //         ->where('kehadiran_id', '!=', EnumKehadiran::HADIR)
    //         ->get();

    //     $cekNihil = Absensi::whereTanggal($tanggal)
    //         ->whereJam($jam)
    //         ->whereIn('nis', $listSiswa->pluck('nis'))
    //         ->whereKehadiranId(EnumKehadiran::HADIR)
    //         ->get();

    //     if (!blank($cekNihil)) {
    //         return;
    //     }

    //     if (!blank($cekTidakHadir)) {
    //         foreach ($listSiswa->whereNotIn('nis', $cekTidakHadir->pluck('nis')) as $siswa) {
    //             $data[] = [
    //                 'tanggal' => $tanggal,
    //                 'tahun' => $tahun,
    //                 'jam' => $jam,
    //                 'kelas_id' => $siswa->kelas_id,
    //                 'semester' => $semester,
    //                 'nis' => $siswa->nis,
    //                 'kehadiran_id' => $kehadiranId,
    //                 'user_id' => $userId
    //             ];
    //         }
    //     } else {
    //         foreach ($listSiswa as $siswa) {
    //             $data[] = [
    //                 'tanggal' => $tanggal,
    //                 'tahun' => $tahun,
    //                 'jam' => $jam,
    //                 'kelas_id' => $siswa->kelas_id,
    //                 'semester' => $semester,
    //                 'nis' => $siswa->nis,
    //                 'kehadiran_id' => $kehadiranId,
    //                 'user_id' => $userId
    //             ];
    //         }
    //     }

    //     Absensi::upsert($data, ['tanggal', 'tahun', 'jam', 'kelas_id', 'semester', 'nis'], ['kehadiran_id', 'user_id']);

    //     return response()->json([
    //         'listSiswa' => RuangUjian::whereTahun($tahun)
    //             ->whereSemester($semester)
    //             ->whereNamaRuang($namaRuang)
    //             ->whereNamaUjian($namaUjian)
    //             ->with(
    //                 [
    //                     'user' => fn ($q) => $q->select('nis', 'name'),
    //                     'kelas' => fn ($q) => $q->select('id', 'nama'),
    //                     'absensi' => fn ($q) => $q
    //                         ->whereTanggal($tanggal)
    //                         ->whereJam($jam),
    //                     'absensi.guru' => fn ($q) => $q->select('id', 'name'),
    //                 ]
    //             )
    //             ->get()
    //             ->sortBy(['kelas.nama', 'user.name'])
    //             ->values(),
    //     ]);
    // }
}

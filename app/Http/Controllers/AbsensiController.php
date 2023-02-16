<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Traits\InitTrait;
use EnumKehadiran;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AbsensiController extends Controller
{

    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/Absensi',
            [
                'initTahun' => $this->data_tahun(),
                'listKehadiran' => Kehadiran::get(),
                'listKelas' => Kelas::orderBy('nama')->get(),
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
            return back()->withErrors(['pesan' => 'Ada data kosong']);
        }

        $tanggal = request('tanggal');
        $tahun = request('tahun');
        $jam = request('jam');
        $kelasId = request('kelasId');
        $semester = $this->data_semester();
        $userId = auth()->user()->id;


        foreach ($inputs as $input) {
            Absensi::updateOrCreate(
                [
                    'tanggal' => $tanggal,
                    'tahun' => $tahun,
                    'jam' => $jam,
                    'kelas_id' => $kelasId,
                    'semester' => $semester,
                    'nis' => $input['nis'],
                ],
                [
                    'kehadiran_id' => $input['absensi']['kehadiran_id'],
                    'user_id' => $userId
                ]
            );
        }
        return to_route('absensi');
    }

    public function nihil()
    {
        request()->validate(
            [
                'tanggal' => 'required',
                'tahun' => 'required',
                'jam' => 'required',
                'kelasId' => 'required'
            ]
        );

        $tanggal = request('tanggal');
        $tahun = request('tahun');
        $jam = request('jam');
        $kelasId = request('kelasId');
        $semester = $this->data_semester();
        $userId = auth()->user()->id;
        $kehadiranId = EnumKehadiran::HADIR;
        $data = [];

        $listSiswa = Siswa::whereTahun($tahun)
            ->whereKelasId($kelasId)
            ->get();

        $cekTidakHadir = Absensi::whereTanggal($tanggal)
            ->whereJam($jam)
            ->whereKelasId($kelasId)
            ->where('kehadiran_id', '!=', EnumKehadiran::HADIR)
            ->get();

        $cekNihil = Absensi::whereTanggal($tanggal)
            ->whereJam($jam)
            ->whereKelasId($kelasId)
            ->whereKehadiranId(EnumKehadiran::HADIR)
            ->get();

        if (!blank($cekNihil)) {
            return;
        }

        if (!blank($cekTidakHadir)) {
            foreach ($listSiswa->whereNotIn('nis', $cekTidakHadir->pluck('nis')) as $siswa) {
                $data[] = [
                    'tanggal' => $tanggal,
                    'tahun' => $tahun,
                    'jam' => $jam,
                    'kelas_id' => $kelasId,
                    'semester' => $semester,
                    'nis' => $siswa->nis,
                    'kehadiran_id' => $kehadiranId,
                    'user_id' => $userId
                ];
            }
        } else {
            foreach ($listSiswa as $siswa) {
                $data[] = [
                    'tanggal' => $tanggal,
                    'tahun' => $tahun,
                    'jam' => $jam,
                    'kelas_id' => $kelasId,
                    'semester' => $semester,
                    'nis' => $siswa->nis,
                    'kehadiran_id' => $kehadiranId,
                    'user_id' => $userId
                ];
            }
        }

        Absensi::upsert($data, ['tanggal', 'tahun', 'jam', 'kelas_id', 'semester', 'nis'], ['kehadiran_id', 'user_id']);

        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with(
                    [
                        'user' => fn ($q) => $q->select('nis', 'name'),
                        'absensi' => fn ($q) => $q
                            ->whereTanggal(request('tanggal'))
                            ->whereJam(request('jam')),
                        'absensi.guru' => fn ($q) => $q->select('id', 'name'),
                    ]
                )
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }
}

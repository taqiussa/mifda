<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\WaliKelas;
use App\Traits\InitTrait;
use App\Models\AturanKurikulum;
use EnumKehadiran;

class PrintRaporController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintRapor',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::get(),
                'initKelasId' => WaliKelas::whereTahun($this->data_tahun())
                    ->whereUserId(auth()->user()->id)
                    ->value('kelas_id')
            ]
        );
    }

    public function print()
    {
        $kelas = Kelas::find(request('kelasId'));
        $tahun = request('tahun');
        $semester = request('semester');
        $nis = request('nis');

        $cekKurikulum = AturanKurikulum::whereTingkat($kelas->id)
            ->whereTahun($tahun)
            ->with(['kurikulum'])
            ->first();

        $siswa = Siswa::whereNis($nis)
            ->with([
                'user',
                'biodata',
                'catatan' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
                'dataAlfa' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
                'nilaiEkstra'  => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
                'nilaiEkstra.ekstra',
                'nilaiEkstra.ekstra.deskripsi',
                'prestasi'  => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
            ])
            ->withCount([
                'absensis as hitung_izin' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester)
                    ->whereKehadiranId(EnumKehadiran::IZIN),
                'absensis as hitung_sakit' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester)
                    ->whereKehadiranId(EnumKehadiran::SAKIT),
            ])
            ->first();
    }
}

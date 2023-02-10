<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\WaliKelas;
use App\Traits\InitTrait;
use EnumKehadiran;

class PrintAbsensiController extends Controller
{
    use InitTrait;

    public $bulan;
    public $tahun;
    public $semester;
    public $kelasId;
    public $maxHadir;

    public $namaKelas;
    public $namaWaliKelas;
    public $namaGuruBk;

    public $listSiswa = [];
    public $listHadir = [];

    public function __construct()
    {
        $this->bulan = request('bulan');
        $this->tahun = request('tahun');
        $this->semester = request('semester');
        $this->kelasId = request('kelasId');

        $this->namaKelas = Kelas::find($this->kelasId)->nama ?? 'Kelas Belum dipilih';
        $this->namaWaliKelas = WaliKelas::whereTahun($this->tahun)
            ->whereKelasId($this->kelasId)
            ->with(['guru' => fn($q) => $q->select('id', 'name')])
            ->first()->guru->name ?? 'Kelas Belum dipilih';
        $this->namaGuruBk = GuruKelas::whereTahun($this->tahun)
            ->whereKelasId($this->kelasId)
            ->with([
                'user' => fn($q) => $q->select('id', 'name'), 
                'mapel' => fn($q) => $q->select('id', 'nama')
                ])
            ->whereHas('mapel', fn ($q) => $q->whereNama('Konseling'))
            ->first()
            ->user->name ?? 'Kelas Belum dipilih';
    }

    public function index()
    {
        return inertia(
            'Guru/PrintAbsensi',
            [
                'initBulan' => date('m'),
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::get()
            ]
        );
    }

    public function print_per_bulan()
    {
        if ($this->kelasId) {
            $this->get_absensi_per_bulan();
        }

        $data = [
            'kelasId' => $this->kelasId,
            'namaKelas' => $this->namaKelas,
            'tahun' => $this->tahun,
            'namaWaliKelas' => $this->namaWaliKelas,
            'namaBulan' => namaBulan($this->bulan),
            'listSiswa' => $this->listSiswa,
            'maxHadir' => $this->maxHadir,
            'namaGuruBk' => $this->namaGuruBk,
        ];

        return view('print.absensi-per-bulan', $data);
    }

    public function print_per_semester()
    {
        if ($this->kelasId) {
            $this->get_absensi_per_semester();
        }

        $data = [
            'kelasId' => $this->kelasId,
            'namaKelas' => $this->namaKelas,
            'tahun' => $this->tahun,
            'semester' => $this->semester,
            'namaWaliKelas' => $this->namaWaliKelas,
            'listSiswa' => $this->listSiswa,
            'maxHadir' => $this->maxHadir,
            'namaGuruBk' => $this->namaGuruBk,
        ];

        return view('print.absensi-per-semester', $data);
    }

    private function get_absensi_per_bulan()
    {
        $this->listSiswa = Siswa::whereTahun($this->tahun)
            ->whereKelasId($this->kelasId)
            ->with([
                'user' => fn($q) => $q->select('nis', 'name'),
            ])
            ->withCount(
                [
                    'hitungAbsensi as hadir'  =>
                    fn ($q) => $q->whereMonth('tanggal', $this->bulan)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::HADIR),
                    'hitungAbsensi as sakit'  =>
                    fn ($q) => $q->whereMonth('tanggal', $this->bulan)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::SAKIT),
                    'hitungAbsensi as izin'  =>
                    fn ($q) => $q->whereMonth('tanggal', $this->bulan)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::IZIN),
                    'hitungAbsensi as alpha'  =>
                    fn ($q) => $q->whereMonth('tanggal', $this->bulan)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::ALPHA),
                    'hitungAbsensi as bolos'  =>
                    fn ($q) => $q->whereMonth('tanggal', $this->bulan)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::BOLOS),
                    'hitungAbsensi as pulang'  =>
                    fn ($q) => $q->whereMonth('tanggal', $this->bulan)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::IZIN_PULANG),
                ]
            )
            ->get()
            ->sortBy('user.name');

        foreach ($this->listSiswa as $key => $siswa) {
            $this->listHadir[$key] = $siswa->hadir;
        }
        $this->maxHadir = max($this->listHadir);
    }

    private function get_absensi_per_semester()
    {
        $this->listSiswa = Siswa::whereTahun($this->tahun)
            ->whereKelasId($this->kelasId)
            ->with([
                'user' => fn($q) => $q->select('nis', 'name'),
            ])
            ->withCount(
                [
                    'hitungAbsensi as hadir'  =>
                    fn ($q) => $q->whereSemester($this->semester)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::HADIR),
                    'hitungAbsensi as sakit'  =>
                    fn ($q) => $q->whereSemester($this->semester)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::SAKIT),
                    'hitungAbsensi as izin'  =>
                    fn ($q) => $q->whereSemester($this->semester)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::IZIN),
                    'hitungAbsensi as alpha'  =>
                    fn ($q) => $q->whereSemester($this->semester)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::ALPHA),
                    'hitungAbsensi as bolos'  =>
                    fn ($q) => $q->whereSemester($this->semester)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::BOLOS),
                    'hitungAbsensi as pulang'  =>
                    fn ($q) => $q->whereSemester($this->semester)
                        ->whereTahun($this->tahun)
                        ->where('kehadiran_id', EnumKehadiran::IZIN_PULANG),
                ]
            )
            ->get()
            ->sortBy('user.name');

        foreach ($this->listSiswa as $key => $siswa) {
            $this->listHadir[$key] = $siswa->hadir;
        }
        $this->maxHadir = max($this->listHadir);
    }
}

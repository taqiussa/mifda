<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\WaliKelas;
use App\Traits\InitTrait;
use App\Models\AturanKurikulum;
use App\Models\JenisSikap;
use App\Models\TanggalRapor;
use EnumKategoriSikap;
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
        $naik = request('naik');

        $cekKurikulum = AturanKurikulum::whereTingkat($kelas->tingkat)
            ->whereTahun($tahun)
            ->with(['kurikulum'])
            ->first();

        $siswa = Siswa::whereNis($nis)
            ->with([
                'user',
                'biodata',
                'catatan' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
                'penilaianEkstrakurikuler'  => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
                'penilaianEkstrakurikuler.ekstra',
                'penilaianEkstrakurikuler.ekstra.deskripsi',
                'prestasi'  => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
            ])
            ->withCount([
                'absensis as hitung_alpha' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester)
                    ->whereKehadiranId(EnumKehadiran::ALPHA),
                'absensis as hitung_izin' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester)
                    ->whereKehadiranId(EnumKehadiran::IZIN),
                'absensis as hitung_sakit' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester)
                    ->whereKehadiranId(EnumKehadiran::SAKIT),
            ])
            ->first();

        $namaWaliKelas = WaliKelas::whereTahun($tahun)
            ->whereKelasId($kelas->id)
            ->with([
                'user' => fn ($q) => $q->select('id', 'name')
            ])
            ->first()
            ->user
            ->name;

        if ($cekKurikulum->kurikulum->nama == 'Kurtilas') {
            $data =
                [
                    'kelasId' => $kelas->id,
                    'namaKelas' => $kelas->nama,
                    'tingkat' => $kelas->tingkat,
                    'namaSiswa' => $siswa->user->name,
                    'nis' => $siswa->nis,
                    'nisn' => $siswa->biodata->nisn,
                    'tahun' => $tahun,
                    'semester' => $semester,
                    'listSikap' => JenisSikap::whereKategoriSikapId(EnumKategoriSikap::P5)->get(),
                    'sakit' => $siswa->hitung_sakit ? floor($siswa->hitung_sakit / 4) : 0,
                    'izin' => $siswa->hitung_izin ? floor($siswa->hitung_izin / 4) : 0,
                    'alpha' => $siswa->hitung_alpha ? floor($siswa->hitung_alpha / 4) : 0,
                    'naik' => $naik,
                    'penilaianEkstrakurikuler' => $siswa->penilaianEkstrakurikuler,
                    'listPrestasi' => $siswa->prestasi,
                    'catatan' => $siswa->catatan,
                    'tanggalRapor' => TanggalRapor::whereTahun($tahun)
                        ->whereSemester($semester)
                        ->first(),
                    'namaWaliKelas' => $namaWaliKelas,
                ];

            return view('print.rapor-kurtilas', $data);
        }

        if ($cekKurikulum->kurikulum->nama == 'Merdeka') {
            $data =
                [
                    'kelasId' => $kelas->id,
                    'namaKelas' => $kelas->nama,
                    'tingkat' => $kelas->tingkat,
                    'namaSiswa' => $siswa->user->name,
                    'nis' => $siswa->nis,
                    'nisn' => $siswa->biodata->nisn,
                    'tahun' => $tahun,
                    'semester' => $semester,
                    'listSikap' => JenisSikap::whereKategoriSikapId(EnumKategoriSikap::P5)->get(),
                    'sakit' => $siswa->hitung_sakit ? floor($siswa->hitung_sakit / 4) : 0,
                    'izin' => $siswa->hitung_izin ? floor($siswa->hitung_izin / 4) : 0,
                    'alpha' => $siswa->hitung_alpha ? floor($siswa->hitung_alpha / 4) : 0,
                    'naik' => $naik,
                    'penilaianEkstrakurikuler' => $siswa->penilaianEkstrakurikuler,
                    'listPrestasi' => $siswa->prestasi,
                    'catatan' => $siswa->catatan,
                    'tanggalRapor' => TanggalRapor::whereTahun($tahun)
                        ->whereSemester($semester)
                        ->first(),
                    'namaWaliKelas' => $namaWaliKelas,
                ];

            return view('print.rapor-merdeka', $data);
        }
    }
}

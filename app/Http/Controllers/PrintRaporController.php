<?php

namespace App\Http\Controllers;

use EnumKehadiran;
use App\Models\Kelas;
use App\Models\Siswa;
use EnumKategoriSikap;
use App\Models\WaliKelas;
use App\Traits\InitTrait;
use App\Models\JenisSikap;
use App\Models\TanggalRapor;
use App\Models\AturanKurikulum;
use App\Models\KurikulumMataPelajaran;
use Barryvdh\DomPDF\Facade\Pdf;
use EnumKategoriNilai;

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
                'penilaianEkstrakurikuler.ekstrakurikuler',
                'penilaianEkstrakurikuler.ekstrakurikuler.deskripsiEkstrakurikuler',
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
                    'kelompok_a' => $this->get_nilai_kurtilas($nis, $kelas->tingkat, 'A'),
                    'kelompok_b' => $this->get_nilai_kurtilas($nis, $kelas->tingkat, 'B'),
                    'kelompok_c' => $this->get_nilai_kurtilas($nis, $kelas->tingkat, 'C'),
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
                    'kelompok_a' => $this->get_nilai_merdeka($nis, $kelas->tingkat, 'A', EnumKategoriNilai::SUMATIF),
                    'kelompok_b' => $this->get_nilai_merdeka($nis, $kelas->tingkat, 'B', EnumKategoriNilai::SUMATIF),
                    'kelompok_c' => $this->get_nilai_merdeka($nis, $kelas->tingkat, 'C', EnumKategoriNilai::SUMATIF),
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
    public function download()
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
                'penilaianEkstrakurikuler.ekstrakurikuler',
                'penilaianEkstrakurikuler.ekstrakurikuler.deskripsiEkstrakurikuler',
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
                    'kelompok_a' => $this->get_nilai_kurtilas($nis, $kelas->tingkat, 'A'),
                    'kelompok_b' => $this->get_nilai_kurtilas($nis, $kelas->tingkat, 'B'),
                    'kelompok_c' => $this->get_nilai_kurtilas($nis, $kelas->tingkat, 'C'),
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

            $pdf = Pdf::loadView('print.rapor-kurtilas', $data)->setPaper(array(0, 0, 595.276, 935.433))->download();
            return response()->streamDownload(
                fn () => print($pdf),
                $siswa->user->name . '.pdf'
            );
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
                    'kelompok_a' => $this->get_nilai_merdeka($nis, $kelas->tingkat, 'A', EnumKategoriNilai::SUMATIF),
                    'kelompok_b' => $this->get_nilai_merdeka($nis, $kelas->tingkat, 'B', EnumKategoriNilai::SUMATIF),
                    'kelompok_c' => $this->get_nilai_merdeka($nis, $kelas->tingkat, 'C', EnumKategoriNilai::SUMATIF),
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

            $pdf = Pdf::loadView('print.rapor-merdeka', $data)->setPaper(array(0, 0, 595.276, 935.433))->download();
            return response()->streamDownload(
                fn () => print($pdf),
                $siswa->user->name . '.pdf'
            );
        }
    }

    private function get_nilai_kurtilas($nis, $tingkat, $kelompok)
    {
        return KurikulumMataPelajaran::where('tahun', request('tahun'))
            ->where('tingkat', $tingkat)
            ->with([
                'mapel',
                'mapel' => [
                    'kkm' => fn ($q) => $q->where('tahun', request('tahun'))
                        ->where('tingkat', $tingkat),
                    'kd' => fn ($q) => $q->where('tahun', request('tahun'))
                        ->where('tingkat', $tingkat),
                    'penilaian' => fn ($q) => $q->where('tahun', request('tahun'))
                        ->where('semester', request('semester'))
                        ->where('nis', $nis),
                ],
            ])
            ->whereHas('mapel', fn ($q) => $q->where('kelompok', $kelompok))
            ->get();
    }

    private function get_nilai_merdeka($nis, $tingkat, $kelompok, $kategori)
    {
        return KurikulumMataPelajaran::where('tahun', request('tahun'))
            ->where('tingkat', $tingkat)
            ->with([
                'mapel',
                'mapel' => [
                    'kkm' => fn ($q) => $q->where('tahun', request('tahun'))
                        ->where('tingkat', $tingkat),
                    'kd' => fn ($q) => $q->where('tahun', request('tahun'))
                        ->where('tingkat', $tingkat)
                        ->where('kategori_nilai_id', $kategori),
                    'penilaian' => fn ($q) => $q->where('tahun', request('tahun'))
                        ->where('semester', request('semester'))
                        ->where('kategori_nilai_id', $kategori)
                        ->where('nis', $nis),
                ],
            ])
            ->whereHas('mapel', fn ($q) => $q->where('kelompok', $kelompok))
            ->get();
    }
}

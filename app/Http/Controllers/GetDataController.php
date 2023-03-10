<?php

namespace App\Http\Controllers;

use App\Models\AturanKurikulum;
use App\Models\Catatan;
use App\Models\GuruKelas;
use App\Models\GuruMataPelajaran;
use App\Models\JenisPenilaian;
use App\Models\JenisSikap;
use App\Models\KategoriNilai;
use App\Models\Kd;
use App\Models\Kelas;
use App\Models\Kkm;
use App\Models\MataPelajaran;
use App\Models\PenilaianRapor;
use App\Models\Siswa;
use App\Models\SiswaEkstrakurikuler;
use App\Models\User;
use App\Models\WaliKelas;

class GetDataController extends Controller
{
    public function get_aturan_kurikulum()
    {
        return response()->json([
            'listAturan' => AturanKurikulum::whereTahun(request('tahun'))
                ->with(['kurikulum'])
                ->orderBy('tingkat')
                ->get()
        ]);
    }

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

    public function get_deskripsi_penilaian()
    {
        return response()->json([
            'listDeskripsi' => Kd::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereMataPelajaranId(request('mataPelajaranId'))
                ->whereTingkat(request('tingkat'))
                ->with([
                    'jenisPenilaian',
                    'kategoriNilai'
                ])
                ->get()
        ]);
    }

    public function get_ekstrakurikuler()
    {
        return response()->json([
            'listSiswa' => SiswaEkstrakurikuler::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'ekstrakurikuler',
                    'user'
                ])
                ->get()
                ->sortBy(['user.name'])
                ->values()
        ]);
    }

    public function get_guru_kelas()
    {
        return response()->json([
            'listGuruKelas' => User::role('Guru')
                ->with([
                    'kelas' => fn ($q)
                    => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                        ->orderBy('kelas_id'),
                    'kelas.kelas',
                    'kelas.mapel'
                ])
                ->orderBy('name')
                ->get()
        ]);
    }

    public function get_jenis_penilaian()
    {
        $tingkat = Kelas::find(request('kelasId'))->tingkat;

        $kurikulumId = AturanKurikulum::whereTahun(request('tahun'))
            ->whereTingkat($tingkat)
            ->value('kurikulum_id');

        $jenisPenilaianId = PenilaianRapor::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereKurikulumId($kurikulumId)
            ->whereKategoriNilaiId(request('kategoriNilaiId'))
            ->pluck('jenis_penilaian_id');

        return response()->json([
            'listJenis' => JenisPenilaian::whereIn('id', $jenisPenilaianId)->get()
        ]);
    }

    public function get_jenis_penilaian_per_tingkat()
    {
        $kurikulumId = AturanKurikulum::whereTahun(request('tahun'))
            ->whereTingkat(request('tingkat'))
            ->value('kurikulum_id');

        $jenisPenilaianId = PenilaianRapor::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereKurikulumId($kurikulumId)
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

        if ($kurikulum == 'Kurtilas') {
            $kategori = KategoriNilai::whereIn('nama', ['Pengetahuan', 'Keterampilan'])->get();
        } else {
            $kategori = KategoriNilai::whereIn('nama', ['Formatif', 'Sumatif'])->get();
        }

        return response()->json([
            'listKategori' => $kategori
        ]);
    }

    public function get_kategori_nilai_per_tingkat()
    {
        $kurikulum = AturanKurikulum::whereTahun(request('tahun'))
            ->whereTingkat(request('tingkat'))
            ->with(['kurikulum' => fn ($q) => $q->select('id', 'nama')])
            ->first()->kurikulum->nama;

        if ($kurikulum == 'Kurtilas') {
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

    public function get_kkm()
    {
        return response()->json([
            'listKkm' => Kkm::whereTahun(request('tahun'))
                ->whereMataPelajaranId(request('mataPelajaranId'))
                ->orderBy('tingkat')
                ->get()
        ]);
    }

    public function get_mata_pelajaran()
    {
        return response()->json([
            'listMataPelajaran' => GuruKelas::whereUserId(auth()->user()->id)
                ->whereTahun(request('tahun'))
                ->with([
                    'mapel'
                ])
                ->distinct()
                ->select('mata_pelajaran_id')
                ->get()
        ]);
    }

    public function get_penilaian_rapor()
    {
        return response()->json([
            'listPenilaian' => PenilaianRapor::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->with([
                    'jenisPenilaian',
                    'kategoriNilai',
                    'kurikulum'
                ])
                ->get()
                ->sortBy(['kurikulum.nama', 'kategoriNilai.nama', 'jenisPenilaian.nama'])
                ->values()
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

    public function get_wali_kelas()
    {
        return response()->json([
            'listWaliKelas' => Kelas::with([
                'waliKelas' => fn ($q) => $q->whereTahun(request('tahun')),
                'waliKelas.user',
            ])
                ->orderBy('nama')
                ->get()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\JenisPenilaian;
use App\Models\KategoriNilai;
use App\Models\Kurikulum;
use App\Models\PenilaianRapor;
use App\Traits\InitTrait;

class AturPenilaianRaporController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/AturPenilaianRapor',
            [
                'initTahun' =>  $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKurikulum' => Kurikulum::orderBy('nama')->get(),
                'listKategori' => KategoriNilai::orderBy('nama')->get(),
                'listJenis' => JenisPenilaian::orderBy('nama')->get(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'kurikulumId' => 'required',
            'kategoriNilaiId' => 'required',
            'jenisPenilaianId' => 'required',
        ]);

        PenilaianRapor::create([
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'kurikulum_id' => request('kurikulumId'),
            'kategori_nilai_id' => request('kategoriNilaiId'),
            'jenis_penilaian_id' => request('jenisPenilaianId'),
        ]);

        return to_route('atur-penilaian-rapor');
    }

    public function hapus()
    {
        PenilaianRapor::destroy(request('id'));

        return to_route('atur-penilaian-rapor');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class GetAnalisisController extends Controller
{
    use InitTrait;

    public $tahun;
    public $semester;
    public $kelasId;
    public $kategoriNilaiId;
    public $jenisPenilaianId;
    public $mataPelajaranId;
    public $jenisAnalisis;

    public function __construct()
    {
        $this->tahun = request('tahun');
        $this->semester = request('semester');
        $this->kelasId = request('kelasId');
        $this->kategoriNilaiId = request('kategoriNilaiId');
        $this->jenisPenilaianId = request('jenisPenilaianId');
        $this->mataPelajaranId = request('mataPelajaranId');
        $this->jenisAnalisis = request('jenisAnalisis');
    }

    public function get_analisis_alquran()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun($this->tahun)
                ->whereKelasId($this->kelasId)
                ->with([
                    'user' => fn ($q) => $q->select('nis', 'name'),
                    'analisisAlquran' => fn ($q) => $q->whereTahun($this->tahun)
                        ->whereSemester($this->semester)
                        ->whereKategoriNilaiId($this->kategoriNilaiId)
                        ->whereJenisPenilaianId($this->jenisPenilaianId),
                    'nilai' => fn ($q) => $q->whereTahun($this->tahun)
                        ->whereSemester($this->semester)
                        ->whereKategoriNilaiId($this->kategoriNilaiId)
                        ->whereJenisPenilaianId($this->jenisPenilaianId),
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }
}

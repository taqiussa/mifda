<?php

namespace App\Exports;

use App\Models\JenisSikap;
use App\Models\Siswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportNilaiSikap implements FromView
{
    public $tahun;
    public $semester;
    public $mataPelajaranId;
    public $kategoriSikapId;
    public $kelasId;

    public function __construct($tahun, $semester, $mataPelajaranId, $kategoriSikapId, $kelasId)
    {
        $this->tahun = $tahun;
        $this->semester = $semester;
        $this->mataPelajaranId = $mataPelajaranId;
        $this->kategoriSikapId = $kategoriSikapId;
        $this->kelasId = $kelasId;
    }

    public function view(): View
    {
        return view('export.export-nilai-sikap', [
            'tahun' => $this->tahun,
            'semester' => $this->semester,
            'mataPelajaranId' => $this->mataPelajaranId,
            'kategoriSikapId' => $this->kategoriSikapId,
            'kelasId' => $this->kelasId,
            'listJenis' => JenisSikap::whereKategoriSikapId($this->kategoriSikapId)->get(),
            'listSiswa' => Siswa::whereTahun($this->tahun)
                ->whereKelasId($this->kelasId)
                ->with([
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy('user.name')
        ]);
    }
}

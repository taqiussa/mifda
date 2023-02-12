<?php

namespace App\Exports;

use App\Models\Siswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportNilai implements FromView
{
    public $tahun;
    public $semester;
    public $kategoriNilaiId;
    public $jenisPenilaianId;
    public $kelasId;

    public function __construct($tahun, $semester, $kategoriNilaiId, $jenisPenilaianId, $kelasId)
    {
        $this->tahun = $tahun;
        $this->semester = $semester;
        $this->kategoriNilaiId = $kategoriNilaiId;
        $this->jenisPenilaianId = $jenisPenilaianId;
        $this->kelasId = $kelasId;
    }

    public function view(): View
    {
        return view('export.export-nilai', [
            'tahun' => $this->tahun,
            'semester' => $this->semester,
            'kategoriNilaiId' => $this->kategoriNilaiId,
            'jenisPenilaianId' => $this->jenisPenilaianId,
            'kelasId' => $this->kelasId,
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

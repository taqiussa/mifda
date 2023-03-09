<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Exports\ExportNilaiSikap;
use App\Imports\ImportNilaiSikap;
use App\Models\KategoriSikap;
use Maatwebsite\Excel\Facades\Excel;

class UploadNilaiSikapController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadNilaiSikap',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKategori' => KategoriSikap::get(),
            ]
        );
    }

    public function export()
    {
        request()->validate(
            [
                'tahun' => 'required',
                'semester' => 'required',
                'mataPelajaranId' => 'required',
                'kategoriSikapId' => 'required',
                'jenisSikapId' => 'required',
                'kelasId' => 'required',
            ],
            [
                'tahun.required' => 'tidak boleh kosong',
                'semester.required' => 'tidak boleh kosong',
                'mataPelajaranId.required' => 'tidak boleh kosong',
                'kategoriSikapId.required' => 'tidak boleh kosong',
                'jenisSikapId.required' => 'tidak boleh kosong',
                'kelasId.required' => 'tidak boleh kosong',
            ]
        );
        $tahun = request('tahun');
        $semester = request('semester');
        $mataPelajaranId = request('mataPelajaranId');
        $kategoriSikapId = request('kategoriSikapId');
        $kelasId = request('kelasId');

        $namaKelas = Kelas::find($kelasId)->nama;
        return Excel::download(new ExportNilaiSikap($tahun, $semester, $mataPelajaranId, $kategoriSikapId, $kelasId),  'Penilaian Sikap - ' . $namaKelas . '.xlsx');
    }

    public function import()
    {
        request()->validate([
            'fileImport' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new ImportNilaiSikap(), request('fileImport'));

        to_route('upload-nilai-sikap');
    }
}

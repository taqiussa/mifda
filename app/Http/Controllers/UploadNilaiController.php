<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Exports\ExportNilai;
use App\Imports\ImportNilai;
use App\Models\JenisPenilaian;
use App\Models\GuruMataPelajaran;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Facades\Excel;

class UploadNilaiController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadNilai',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMataPelajaran' => GuruMataPelajaran::whereUserId(auth()->user()->id)
                    ->with([
                        'mapel'
                    ])
                    ->get(),
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
                'kategoriNilaiId' => 'required',
                'jenisPenilaianId' => 'required',
                'kelasId' => 'required',
            ],
            [
                'tahun.required' => 'tidak boleh kosong',
                'semester.required' => 'tidak boleh kosong',
                'mataPelajaranId.required' => 'tidak boleh kosong',
                'kategoriNilaiId.required' => 'tidak boleh kosong',
                'jenisPenilaianId.required' => 'tidak boleh kosong',
                'kelasId.required' => 'tidak boleh kosong',
            ]
        );
        $tahun = request('tahun');
        $semester = request('semester');
        $mataPelajaranId = request('mataPelajaranId');
        $kategoriNilaiId = request('kategoriNilaiId');
        $jenisPenilaianId = request('jenisPenilaianId');
        $kelasId = request('kelasId');

        $namaKelas = Kelas::find($kelasId)->nama;
        $namaJenisPenilaian = JenisPenilaian::find($jenisPenilaianId)->nama;
        $namaMapel = MataPelajaran::find($mataPelajaranId)->nama;
        return Excel::download(new ExportNilai($tahun, $semester, $mataPelajaranId, $kategoriNilaiId, $jenisPenilaianId, $kelasId),  $namaMapel . ' - ' . $namaJenisPenilaian . ' - ' . $namaKelas . '.xlsx');
    }

    public function import()
    {
        request()->validate([
            'fileImport' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new ImportNilai(), request('fileImport'));

        to_route('upload-nilai');
    }
}

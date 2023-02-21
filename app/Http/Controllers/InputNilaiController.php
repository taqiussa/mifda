<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Traits\InitTrait;
use App\Models\GuruMataPelajaran;

class InputNilaiController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilai',
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

    public function simpan()
    {
        request()->validate([
            'nis' => 'required',
            'nilai' => 'required',
        ]);

        $nis = request('nis');
        $nilai = request('nilai');


        Penilaian::updateOrCreate(
            [
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
                'kelas_id' => request('kelasId'),
                'nis' => $nis,
            ],
            [
                'tanggal' => date('Y-m-d'),
                'user_id' => auth()->user()->id,
                'nilai' => $nilai,
            ]
        );

        return response()->json([
            'message' => 'Tersimpan',
            'nis' => $nis
        ]);
    }
}

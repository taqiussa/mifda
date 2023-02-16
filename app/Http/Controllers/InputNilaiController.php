<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Traits\InitTrait;
use Illuminate\Http\Request;
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

    public function simpan(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'mataPelajaranId' => 'required',
            'kelasId' => 'required',
            'kategoriNilaiId' => 'required',
            'jenisPenilaianId' => 'required',
        ]);

        $inputs = $request->arrayInput;
        foreach ($inputs as $input) {
            if (intval($input['nilai']['nilai'] > 100)) {
                return back()->withErrors(['pesan' => 'Periksa Data, Nilai Tidak Boleh Lebih Dari 100']);
            }
        }

        foreach ($inputs as $input) {
            Penilaian::updateOrCreate(
                [
                    'tahun' => $request->tahun,
                    'semester' => $request->semester,
                    'mata_pelajaran_id' => $request->mataPelajaranId,
                    'kategori_nilai_id' => $request->kategoriNilaiId,
                    'jenis_penilaian_id' => $request->jenisPenilaianId,
                    'kelas_id' => $request->kelasId,
                    'nis' => $input['nis'],
                ],
                [
                    'tanggal' => date('Y-m-d'),
                    'user_id' => auth()->user()->id,
                    'nilai' => $input['nilai']['nilai'] ?? null,
                ]
            );
        }

        return to_route('input-nilai');
    }
}

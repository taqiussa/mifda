<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use Illuminate\Http\Request;
use App\Models\GuruMataPelajaran;
use App\Models\KategoriSikap;
use App\Models\PenilaianSikap;

class InputNilaiSikapController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilaiSikap',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMataPelajaran' => GuruMataPelajaran::whereUserId(auth()->user()->id)
                    ->with([
                        'mapel'
                    ])
                    ->get(),
                'listKategori' => KategoriSikap::get(),
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
            'kategoriSikapId' => 'required',
            'jenisSikapId' => 'required',
        ]);

        $inputs = $request->arrayInput;

        foreach ($inputs as $input) {
            PenilaianSikap::updateOrCreate(
                [
                    'tahun' => $request->tahun,
                    'semester' => $request->semester,
                    'mata_pelajaran_id' => $request->mataPelajaranId,
                    'kategori_sikap_id' => $request->kategoriSikapId,
                    'jenis_sikap_id' => $request->jenisSikapId,
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

        return to_route('input-nilai-sikap');
    }
}

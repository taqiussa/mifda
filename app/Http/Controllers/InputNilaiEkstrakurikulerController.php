<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\PenilaianEkstrakurikuler;
use App\Traits\InitTrait;

class InputNilaiEkstrakurikulerController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/InputNilaiEkstrakurikuler', [
            'initTahun' => $this->data_tahun(),
            'initSemester' => $this->data_semester(),
            'listEkstrakurikuler' => Ekstrakurikuler::orderBy('nama')->get(),
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'ekstrakurikulerId' => 'required'
        ]);

        $inputs = request('arrayInput');

        foreach ($inputs as $input) {
            if (intval($input['nilai'] ? $input['nilai']['nilai'] : 0 ) > 100) {
                return back()->withErrors(['pesan' => 'Periksa Data, Nilai Tidak Boleh Lebih Dari 100']);
            }
        }

        foreach ($inputs as $input) {
            PenilaianEkstrakurikuler::updateOrCreate(
                [
                    'tahun' => request('tahun'),
                    'semester' => request('semester'),
                    'ekstrakurikuler_id' => request('ekstrakurikulerId'),
                    'kelas_id' => $input['kelas']['id'],
                    'nis' => $input['nis'],
                ],
                [
                    'user_id' => auth()->user()->id,
                    'nilai' => $input['nilai']['nilai'] ?? null,
                ]
            );
        }

        return to_route('input-nilai-ekstrakurikuler');
    }
}

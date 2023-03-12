<?php

namespace App\Http\Controllers;

use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        return inertia('Guru/Kelas', [
            'listKelas' => Kelas::orderBy('nama')->get(),
        ]);
    }

    public function edit($id)
    {
        return response()->json([
            'kelas' => Kelas::find($id)
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'nama' => 'required',
            'tingkat' => 'required'
        ]);

        Kelas::updateOrCreate(
            [
                'id' => request('id')
            ],
            [
                'nama' => request('nama'),
                'tingkat' => request('tingkat')
            ]
        );

        return to_route('kelas');
    }
}

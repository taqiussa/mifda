<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function index()
    {
        return inertia('Guru/MataPelajaran', [
            'listMataPelajaran' => MataPelajaran::get()
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'nama' => 'required',
            'kelompok' => 'required'
        ]);

        MataPelajaran::updateOrCreate(
            [
                'id' => request('id')
            ],
            [
                'nama' => request('nama'),
                'kelompok' => request('kelompok')
            ]
        );

        return to_route('mata-pelajaran');
    }

    public function edit($id)
    {
        return response()->json([
            'mataPelajaran' => MataPelajaran::find($id)
        ]);
    }
}

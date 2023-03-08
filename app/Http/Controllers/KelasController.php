<?php

namespace App\Http\Controllers;

use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        return inertia('Guru/Kelas', [
            'listKelas' => Kelas::get(),
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
            'nama' => 'required'
        ]);

        Kelas::updateOrCreate(
            [
                'id' => request('id')
            ],
            [
                'nama' => request('nama')
            ]
        );

        return to_route('kelas');
    }
}

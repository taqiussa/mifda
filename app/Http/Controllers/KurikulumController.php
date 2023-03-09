<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function index()
    {
        return inertia('Guru/Kurikulum', [
            'listKurikulum' => Kurikulum::orderBy('nama')->get()
        ]);
    }

    public function edit($id)
    {
        return response()->json([
            'kurikulum' => Kurikulum::find($id)
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'nama' => 'required'
        ]);

        Kurikulum::updateOrCreate(
            [
                'id' => request('id')
            ],
            [
                'nama' => request('nama')
            ]
        );

        return to_route('kurikulum');
    }
}

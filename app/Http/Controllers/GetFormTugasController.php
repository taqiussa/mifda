<?php

namespace App\Http\Controllers;

use App\Models\Badalan;
use Illuminate\Http\Request;

class GetFormTugasController extends Controller
{
    public function get_tugas(Request $request)
    {
        return response()->json([
            'listTugas' => Badalan::whereTanggal($request->tanggal)
                ->whereUserId(auth()->user()->id)
                ->with([
                    'kelas' => fn ($q) => $q->selecT('id', 'nama'),
                    'badal' => fn ($q) => $q->select('id', 'name')
                ])
                ->get()
                ->sortBy('jam')
                ->values()
        ]);
    }
}

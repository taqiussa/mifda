<?php

namespace App\Imports;

use App\Models\PenilaianSikap;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportNilaiSikap implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            PenilaianSikap::updateOrCreate(
                [
                    'tahun' => $row['tahun'],
                    'semester' => $row['semester'],
                    'mata_pelajaran_id' => $row['mata_pelajaran_id'],
                    'kategori_sikap_id' => $row['kategori_sikap_id'],
                    'jenis_sikap_id' => $row['jenis_sikap_id'],
                    'kelas_id' => $row['kelas_id'],
                    'nis' => $row['nis'],
                ],
                [
                    'tanggal' => date('Y-m-d'),
                    'user_id' => auth()->user()->id,
                    'nilai' => $row['nilai'] ?? null,
                ]
            );
        }
    }
}

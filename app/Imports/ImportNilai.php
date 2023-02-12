<?php

namespace App\Imports;

use App\Models\Penilaian;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportNilai implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Penilaian::updateOrCreate(
                [
                    'tahun' => $row['tahun'],
                    'semester' => $row['semester'],
                    'mata_pelajaran_id' => $row['mataPelajaranId'],
                    'kategori_nilai_id' => $row['kategoriNilaiId'],
                    'jenis_penilaian_id' => $row['jenisPenilaianId'],
                    'kelas_id' => $row['kelasId'],
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

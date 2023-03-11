<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenilaianRapor extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the jenisPenilaian that owns the PenilaianRapor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisPenilaian(): BelongsTo
    {
        return $this->belongsTo(JenisPenilaian::class)->withDefault();
    }

    /**
     * Get the kategoriNilai that owns the PenilaianRapor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategoriNilai(): BelongsTo
    {
        return $this->belongsTo(KategoriNilai::class)->withDefault();
    }

    /**
     * Get the kurikulum that owns the PenilaianRapor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kurikulum(): BelongsTo
    {
        return $this->belongsTo(Kurikulum::class)->withDefault();
    }
}

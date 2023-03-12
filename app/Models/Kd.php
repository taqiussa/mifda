<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kd extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the jenisPenilaian that owns the Kd
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisPenilaian(): BelongsTo
    {
        return $this->belongsTo(JenisPenilaian::class)->withDefault();
    }

    /**
     * Get the kategori that owns the Kd
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategoriNilai(): BelongsTo
    {
        return $this->belongsTo(KategoriNilai::class)->withDefault();
    }
}

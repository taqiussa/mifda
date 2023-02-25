<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataPelajaran extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the kkm that owns the MataPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kkm(): BelongsTo
    {
        return $this->belongsTo(Kkm::class)->withDefault();
    }

    /**
     * Get all of the kd for the MataPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kd(): HasMany
    {
        return $this->hasMany(Kd::class);
    }

    /**
     * Get all of the penilaian for the MataPelajaran
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'mata_pelajaran_id');
    }
}

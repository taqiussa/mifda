<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiswaEkstrakurikuler extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the kelas that owns the SiswaEkstrakurikuler
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    /**
     * Get the nilai that owns the SiswaEkstrakurikuler
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nilai(): BelongsTo
    {
        return $this->belongsTo(PenilaianEkstrakurikuler::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get the user that owns the SiswaEkstrakurikuler
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nis', 'nis')->withDefault();
    }
}

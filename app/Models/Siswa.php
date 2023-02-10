<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Siswa extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the absensi that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function absensi(): BelongsTo
    {
        return $this->belongsTo(Absensi::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get all of the hitungAbsensi for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hitungAbsensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'nis', 'nis');
    }

    /**
     * Get the biodata associated with the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function guru(): HasOneThrough
    {
        // nis dari absensi, id dari User    , nis dari siswa, user_id dari absensi;
        return $this->hasOneThrough(User::class, Absensi::class, 'nis', 'id', 'nis', 'user_id')->withDefault();
    }

    /**
     * Get the kelas that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class)->withDefault();
    }

    /**
     * Get the nilai that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nilai(): BelongsTo
    {
        return $this->belongsTo(Penilaian::class, 'nis', 'nis')->withDefault();
    }

    /**
     * Get all of the penilaian for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function penilaian(): HasMany
    {
        return $this->hasMany(Penilaian::class, 'nis', 'nis');
    }

    /**
     * Get the user that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nis', 'nis')->withDefault();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the waliKelas that owns the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function waliKelas(): BelongsTo
    {
        return $this->belongsTo(WaliKelas::class, 'id', 'kelas_id')->withDefault();
    }
}

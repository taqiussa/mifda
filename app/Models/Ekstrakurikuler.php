<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekstrakurikuler extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the deskripsiEkstrakurikuler that owns the Ekstrakurikuler
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deskripsiEkstrakurikuler(): BelongsTo
    {
        return $this->belongsTo(DeskripsiEkstrakurikuler::class)->withDefault();
    }
}

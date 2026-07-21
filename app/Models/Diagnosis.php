<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnosis extends Model
{
    use SoftDeletes;

    protected $table = 'diagnosis';

    protected $fillable = [
        'pasien_id',
        'penyakit_id',
        'nilai_preferensi',
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function penyakit(): BelongsTo
    {
        return $this->belongsTo(Penyakit::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(DiagnosisDetail::class);
    }
}
